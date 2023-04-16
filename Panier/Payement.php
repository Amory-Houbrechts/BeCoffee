<?php 
date_default_timezone_set('Europe/Brussels');
$dateTime = date('d/m/Y H:i:s') ;

require '../INC/DB.php';

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password);

if (isset($_GET['CardID']) && isset($_GET['Total']) && isset($_GET['Order'])) {
	
	$payment_id = rand(10000000, 99999999);

	$CardNumber = base64_decode($_GET['CardID']);
	$Total = base64_decode($_GET['Total']);
	$order_id = base64_decode($_GET['Order']);

	$New_Payment = $pdo->prepare("INSERT INTO payment SET ID = ?, CardNumber = ?,DateGenerate = NOW(), Total = ?");
	$New_Payment->execute([$payment_id, $CardNumber, $Total]);

	$Update_Order = $pdo->prepare("UPDATE Orders SET PaymentID = ? WHERE ID = ?");
	$Update_Order->execute([$payment_id, $order_id]);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<title>Payement</title>
</head>
<body>
	<header>
		<!--IMG Banque + Icone carte-->
		ici
	</header>
	<main>
		<section>
			Confirmer votre payement
		</section>
		<section>
			<table>
				<tr>
					<th>Commerçant:</th>
					<td>BeDrink</td>
				</tr>
				<tr>
					<th>Montant:</th>
					<td><?= number_format(($Total),2,',',' ') ?> EUR</td>
				</tr>
				<tr>
					<th>Date:</th>
					<td><?= $dateTime ?> (GMT / Heure locale)</td>
				</tr>
				<tr>
					<th>Numéro de carte:</th>
					<td><?= $CardNumber ?></td>
				</tr>
			</table>
		</section>
		<section>
			<ol>
				<li><strong>Insérez votre carte dans le lecteur de carte et appuyez sur</strong> <div class="button M2">M2</div></li>
				<li>'Pin' s'affiche.<br><strong>Introduisez votre code PIN et appuyez sur</strong> <div class="button OK">OK</div></li>
				<li>'DATA or OK?' s'affiche<br><strong>Introduisez le code <div class="Number"><?= $Total*100 ?></div> et appuyez sur</strong> <div class="button OK">OK</div></li>
				<li>'DATA or OK?' s'affiche<br><strong>Introduisez le code <div class="Number"><?= rand(10000, 99999) ?></div> et appuyez sur</strong> <div class="button OK">OK</div> <div class="button OK">OK</div></li>
				<li>La signature électronique s'affiche<br><strong>Introduisez la signature électronique </strong><input type="number" name="token" placeholder="Ex: 123456789" required></li>
			</ol>
		</section>
		<section>
			<button type="button">Annuler</button>
			<button type="submit">Valider</button>
		</section>
	</main>
</body>
</html>

<style type="text/css">
	body{
		padding: 0;
		margin: 0;
		background-color: #e0e3e8;
	}

	div.button{
		background-color: #262626;
		color: #fff;
		width: 30px;
		height: 30px;
		border-radius: 70%;
		text-align: center;
		display: inline-block;
	}

	div.M2{
		background-color: #156298;
	}

	div.OK{
		background-color: #009865;
	}

	div.Number{
		background-color: #fff;
		color: #9cb6ce;
		width: fit-content;
		display: inline-block;
	}

	main{
		width: 80%;
		height: 90vh;
		margin: auto;
	}

	section{
		background-color: #fff;
		margin: 0;
  		padding: 5px;
	}

	section:nth-child(1){
		background-color: rgb(134, 27, 97, 1);
		color: #fff;
		font-size: 25px;
		height: 50px;
	}

	button{
		border: none;
		width: 200px;
		height: 40px;
	}

	button:nth-child(2){
		background-color: #009865;
		color: #fff;
	}

	section table{
		width: 100%;
	}

	section:last-child{
		text-align: right;
	}

	section:nth-child(3){
		background-color: #f4f5f7;
	}
</style>

<?php 
}
?>