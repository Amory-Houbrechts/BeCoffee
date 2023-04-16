<?php 

require '../INC/DB.php';
require '../INC/Fonction.php';
$url = "http://".$_SERVER['HTTP_HOST']."/BeCoffee/";

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['Submit'])) {
	$Login = $pdo->prepare('SELECT * FROM Users WHERE Email = ?');
	$Login->execute([$_POST['Email']]);
	$InfoUser = $Login->fetch();

	if($InfoUser){
		$Before = substr($InfoUser['Name'], 0, 2);
	    $After = substr($InfoUser['Surname'], -2, 2);

	    define("PRE", $Before);
	    define("POST",$After);

		$Password = Secure::hash($_POST['Password']);

		if ($Password == $InfoUser['Password']) {

			if(!isset($_SESSION)) {
				session_start();
			}		

			$_SESSION['auth'] = $InfoUser;

			header("Location: ".$url."Catalog/");
			exit;
		}else{
			$_SESSION['notification']['type'] = "error";
			$_SESSION['notification']['message'] = "Mot de passe incorrect";

			header("Location: ".$url."User/Login");
			exit;
		}
	}else{
		echo "Email not fund";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?= $url ?>CSS/Styles.css">
	<title>Inscription</title>
</head>
<body>
	<main class="ForRegister">

		<section class="ImageCoffe">
			<h1>BeCoffee</h1>
			<p>Un grain le matin, en forme jusqu'au lendemain</p>
		</section>
		<section class="Register">
			<h1>Me connecter	</h1>
			<hr>
			<form method="POST">
				<div class="Info">
					<div class="form-group">
						<input type="email" id="Email" name="Email" required>
						<label for="Email">Email</label>
					</div>
					<div class="form-group">
						<input type="password" id="Password" name="Password" required>
						<label for="Password">Mot de passe</label>
					</div>
				</div>
				<br>
				<input type="Submit" name="Submit">
				<br>
			</form>
			<br>
			<a href="Register.php">M'inscrire</a>
			<br>
			<a href="Reset.php">Mot de passe oublié</a>
		</section>
	</main>
</body>
</html>