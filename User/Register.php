<?php 

require '../INC/DB.php';
require '../INC/Fonction.php';
$url = "http://".$_SERVER['HTTP_HOST']."/BeCoffee/";

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password);

if (isset($_POST['Submit'])) {

	if ($_POST['Password'] === $_POST['ConfirmPassword']) {
		$Before = substr($_POST['Name'], 0, 2);
	    $After = substr($_POST['Surname'], -2, 2);

	    define("PRE", $Before);
	    define("POST",$After);

		$Password = Secure::hash($_POST['Password']);

		$token = str_random(60);

		$AddNewUser = $pdo->prepare('INSERT INTO Users SET Name = ?, Surname = ?, Sexe = ?, Email = ?, Birthday = ?, Address = ?, CP = ?, Commune = ?,  Password = ?, DateTimeRegister = NOW(), Token = ?');
		$AddNewUser->execute([$_POST['Name'], $_POST['Surname'], $_POST['gender'], $_POST['Email'], $_POST['DDN'], $_POST['Address'], $_POST['CP'], $_POST['Commune'], $Password, $token]);

		$user_id = $pdo->lastInsertId();

		SendMail($_POST['Email'], "Confirmation de votre inscription", "<html>
<body style='background-color: #EAEAEA;'>
	<header style='text-align: center;'>
		<img src='https://i.ibb.co/tm2B2cz/Be-Coffee1.png' style='height: 150px; margin: 20px;'>
	</header>
	<section style='background-color: #fff; width: 90%; margin: auto; padding: 20px; text-align: center;box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);'>
		<h1>Confirmation</h1>
		<p>Bienvenue ".$_POST['Surname'].", merci pour votre inscription. Cliquez sur le boutton ci-dessous pour activer votre compte.</p>
		<br>
		<a href='".$url."User/CheckAuth?Token=".$token."&UserID=".$user_id."'>
			<button style='width: 300px; height: 50px; font-weight: bold; background-color: #ce710c; color: #fff; border: none;'>Activer mon compte</button>
		</a>
		<br>
		<br>
		<img src='https://ouch-cdn2.icons8.com/PnHn2Ls-F9Prg1WRQC1pkd80MZaGosdkehWavafNjn4/rs:fit:544:456/czM6Ly9pY29uczgu/b3VjaC1wcm9kLmFz/c2V0cy9wbmcvODQ0/LzBhZWNkMWZlLTkw/YzUtNGY4OS05MjZl/LTc5Yjk0MGVkMzZm/Mi5wbmc.png' style='height: 200px;'>
		<hr>
		<br>
		<a href='".$url."User/CheckAuth?Token=".$token."&UserID=".$user_id."' style='color: #292929;'>".$url."User/CheckAuth?Token=".$token."&UserID=".$user_id."</a>
	</section>
</body>
</html>");

		$_SESSION['notification']['type'] = "success";
		$_SESSION['notification']['message'] = "Test";

		header("Location: ".$url."User/CheckAuth?Status=VerifMail");
		exit;

	}else{
		$_SESSION['notification']['type'] = "danger";
		$_SESSION['notification']['message'] = "Erreur";
		echo "Error";
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
	<link rel="stylesheet" type="text/css" href="<?= $url; ?>CSS/Styles.css">
	<title>Inscription</title>
</head>
<body>
	<main>
		<section class="Register">
			<h1>Bienvenue ☕</h1>
			<hr>
			<form method="POST">
                <div class="maxl">
                    <form method="POST" action="#">
                    <label class="radio inline"> 
                        <input type="radio" name="gender" value="00" checked>
                        <span>Femme</span> 
                    </label>
                    <label class="radio inline"> 
                        <input type="radio" name="gender" value="01">
                        <span>Homme</span> 
                    </label>
                    <label class="radio inline"> 
                        <input type="radio" name="gender" value="10">
                        <span>Autre</span> 
                    </label>
                </div>
				<div class="Info">
					<div class="form-group">
						<input type="text" id="Name" name="Name" required>
						<label for="Name">Nom</label>
					</div>
					<div class="form-group">
						<input type="text" id="Surname" name="Surname" required>
						<label for="Surname">Prénom</label>
					</div>
					<div class="form-group">
						<input type="email" id="Email" name="Email" required>
						<label for="Email">Email</label>
					</div>
					<div class="form-group">
						<input type="date" id="DDN" name="DDN" required>
						<label for="DDN">Date de naissance</label>
					</div>
					<div class="form-group">
						<input type="text" id="Address" name="Address" required>
						<label for="Address">Address</label>
					</div>
					<div class="form-group">
						<input type="number" id="CP" name="CP" required>
						<label for="CP">Code postal</label>
					</div>
					<div class="form-group">
						<input type="text" id="Commune" name="Commune" required>
						<label for="Commune">Commune</label>
					</div>
					<div class="form-group">
						<input type="password" id="Password" name="Password" required>
						<label for="Password">Mot de passe</label>
					</div>
					<div class="form-group">
						<input type="password" id="ConfirmPassword" name="ConfirmPassword" required>
						<label for="ConfirmPassword">Confirmation du mot de passe</label>
					</div>
				</div>
				<br>
				<input type="Submit" name="Submit">
				<br>
			</form>
			<a href="Login.php">Me connecter</a>
		</section>
		<section class="ImageCoffe">
			<h1>BeCoffee</h1>
			<p>Un grain le matin, en forme jusqu'au lendemain</p>
		</section>
	</main>
</body>
</html>

<style type="text/css">
	main {
		display: flex;
	}
	section.Register{
		width: 600px;
	}

	section.Register div.Info{
		display: flex;
		flex-wrap: wrap;
	    align-items: center;
	    flex-direction: row;
	}

	section.ImageCoffe{
		background-image: url("../Asset/Background/Register.jpg");
		background-size: auto 100%;
		width: calc(100% - 600px);
		height: 100vh;
		color: #fff;
		text-align: center;
	}

	section.ImageCoffe h1{
		font-size: 100px;
	}

	section.Register{
		padding: 20px;
	}

	input[type="submit"]{
		width: 100%;
		text-align: center;
		margin: auto;
		color: #fff;
		background-color: #785d2e;
		border: none;
		font-weight: bold;
		height: 40px;
	}

	input[type="submit"]:hover{
		background-color: #b89048;
	}

</style>