<?php 

require '../INC/Header.php';

?>


<main class="Account">
	<section class="User T1">
		<img src="../Asset/Avatar/cup.png">
		<br><br>
		<h4><strong style="text-transform: uppercase;"><?= $_SESSION['auth']['Name'] ?></strong> <?= $_SESSION['auth']['Surname'] ?></h4>
	</section>
	<section class="Title T1">
		<h1>Mon compte</h1>
	</section>
	<section class="Points T1">
		<div>
			<img src="../Asset/Avatar/Finance.gif">
		</div>
		<h2>100</h2>
	</section>
	<section class="LastOrder T3">
		<h4>Historique de vos achats</h4>
		<hr>
	</section>
</main>
<style type="text/css">
	body{
		background-color: #F8F8FA;
	}
</style>