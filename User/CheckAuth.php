<?php 

require '../INC/Header.php';

if (isset($_GET['Token']) AND isset($_GET['UserID'])) {

	$VerifMail = $pdo->prepare('SELECT * FROM Users WHERE ID = ? AND Token = ?');
	$VerifMail->execute([$_GET['UserID'], $_GET['Token']]);
	$UserCheck = $VerifMail->fetch();

	if ($UserCheck) {

		$ValidUser = $pdo->prepare('UPDATE Users SET Token = Null, DateTimeValidToken = NOW() WHERE ID = ?');
		$ValidUser->execute([$testUser]);

		if(!isset($_SESSION)) {
			session_start();
		}		

		$_SESSION['auth'] = $UserCheck;

		header("refresh:5; url=".$url."User/Account");

		?>
		<main>
			<section class="ConfirmMail">
				<img src="../Asset/Avatar/Mail.png">
				<div>
					<h1>Confirmation de votre mail avec succès</h1>
					<p>Redirection automatique vers votre compte</p>
				</div>
			</section>
		</main>
		<?php
	}else{
		header("Location: ".$url);
		exit;
	}
}elseif (isset($_GET['Status'])) {
	if ($_GET['Status'] == "VerifMail") {
		?>

		<main class="SendMail">
			<section>
				<img src="../Asset/Avatar/SendMail.gif">
				<h1>Merci pour votre inscription, un mail vous a été envoyé afin de valider celle-ci</h1>
			</section>
		</main>

		<?php
	}else{
		header("Location: ".$url);
		exit;
	}
}else{
	header("Location: ".$url);
	exit;
}
?>