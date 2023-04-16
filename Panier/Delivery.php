<?php 

require '../INC/Header.php';
require '../INC/Fonction.php';

$Total = 0;

if (!isset($_SESSION['auth'])) {
	header('Location: '.$url.'User/Login');
	exit;
}

foreach ($_SESSION['Panier'] as $Product_ID => $Product_Quantity) {
	$Load_Product = $pdo->prepare("SELECT * FROM products WHERE ID = ?");
	$Load_Product->execute([$Product_ID]);

	$Product = $Load_Product->fetch();

	$Total += $Product['Price']*$Product_Quantity;
}

if (isset($_POST['Submit'])) {

	//if (validateBelgianCardNumber($_POST['cardNumber'])) {

		$order_id = rand(100000, 999999);


		$Address = $_POST['address']." ".$_POST['CP']." ".$_POST['Commune']." BELGIUM";

		$Add_Order = $pdo->prepare("INSERT INTO orders SET ID = ?, Address = ?, TypePayment = ?, Status = 1, DateOrder = NOW(), User = ?");
		$Add_Order->execute([$order_id, $Address, "Bancontact", $_SESSION['auth']['ID']]);

		foreach ($_SESSION['Panier'] as $Product_ID => $Product_Quantity) {
			$Add_Product_To_List = $pdo->prepare("INSERT INTO listproduct SET Orders = ?, Product = ?, Quantity = ?");
			$Add_Product_To_List->execute([$order_id,$Product_ID, $Product_Quantity]);
		}

		$link = $url.'Panier/Payement?Order='.base64_encode($order_id).'&CardID='.base64_encode($_POST['cardNumber']).'&Total='.base64_encode($_SESSION['TotalPanier']);

		unset($_SESSION['Panier']);
		unset($_SESSION['TotalPanier']);

		header('Location: '.$link);
		exit;
		
	/*}else{
		echo "Numéro de carte incorrect";
	}*/
}

?>
<br>
<section class="Panier">
	<div class="col-9">
		<form method="POST">
			<article class="Delivery">
				<h4><i class="fa-solid fa-truck-ramp-box"></i> Livraison</h4>
				<div class="InputDelivery">
					<div class="form-group">
						<input type="text" id="name" name="name" value="<?= $_SESSION['auth']['Name'] ?>" required>
						<label for="name">Nom</label>
					</div>
					<div class="form-group">
						<input type="text" id="surname" name="surname" value="<?= $_SESSION['auth']['Surname'] ?>" required>
						<label for="surname">Prénom</label>
					</div>
					<div class="form-group">
						<input type="text" id="address" name="address" value="<?= $_SESSION['auth']['Address'] ?>" required>
						<label for="address">Adresse</label>
					</div>
					<div class="form-group">
						<input type="number" id="CP" name="CP" value="<?= $_SESSION['auth']['CP'] ?>" required>
						<label for="CP">Code Postal</label>
					</div>
					<div class="form-group">
						<input type="text" id="Commune" name="Commune" value="<?= $_SESSION['auth']['Commune'] ?>" required>
						<label for="Commune">Commune</label>
					</div>
				</div>
			</article>
			<br>
			<article class="payment">
				<h4><i class="fa-solid fa-credit-card"></i> Payement</h4>
				<br>
				<div class="form-group">
					<input type="number" id="cardNumber" name="cardNumber" required>
					<label for="cardNumber">Numéro de carte</label>
				</div>
			</article>
			<article class="Buy">
				<br>
				<button type="submit" name="Submit">Payer <i class="fa-solid fa-arrow-right"></i></button>
				<br>
			</article>
		</form>
	</div>
	<div class="col-sm-3">
	  <article class="Total">
	  	<h4>Total</h4>
	  	<hr>
	  	<table>
	  		<tr>
	  			<th><h6>Sous-Total: </h6></th>
	  			<th><?= number_format(($Total/1.21),2,',',' ') ?> €</th>
	  		</tr>
	  		<tr>
	  			<th><h6>TVA: </h6></th>
	  			<th><?= number_format(($Total - $Total/1.21),2,',',' ') ?> €</th>
	  		</tr>
	  		<tr>
	  			<th><h6>Total TTC: </h6></th>
	  			<th><?= number_format(($Total),2,',',' ') ?> €</th>
	  		</tr>
	  	</table>
	  	<br>
	  	<img src="../Asset/Avatar/Payement.png" style="transform: scaleX(-1);">
	  </article>
	</div>
</section>