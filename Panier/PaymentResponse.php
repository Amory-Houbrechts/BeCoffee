<?php 

require '../INC/Header.php';

$State = 1;

?>
<main>
	<?php 
	if ($State==1) {
	?>
	<section>
		<img src="<?= $url ?>Asset/Avatar/success.png">
		<div>
			<h1>Merci pour votre achat <a href="#">N°1228998430</a> !</h1>
			<p>Redirection automatique dans quelques secondes</p>
		</div>
	</section>
	<?php
	}else{
	?>
	<section>
		<img src="<?= $url ?>Asset/Avatar/erreur.png">
		<div>
			<h1>Une erreur avec votre payement est survenue</h1>
			<p>Pour plus d'info, rendez-vous dans l'onglet "<a href="<?= $url ?>User/Order.php">Mes commandes</a>"</p>
		</div>
	</section>
	<?php
	}
	?>
</main>
<style type="text/css">
	section{
		display: flex;
		flex-direction: row;
	    align-items: center;
	    justify-content: space-around;
	    text-align: center;
	    margin: 10px;
	}
</style>