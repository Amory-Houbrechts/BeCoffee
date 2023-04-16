<?php 

require '../INC/Header.php';

$Total = 0;

if (isset($_GET['delete'])) {
	unset($_SESSION['Panier'][$_GET['delete']]);
	header('Location: '.$url.'Panier/');
	exit;
}

if (isset($_GET['RefrechPanier'])) {
	$i=0;
	foreach ($_POST['Product'] as $Quantity) {
		$_SESSION['Panier'][$_POST['ID'][$i]] = $Quantity;
		$i++;
	}

	header('Location: '.$url.'Panier/');
	exit;
}

?>
<main class="Panier">
	<section class="col-9 Product">
		<h4>Articles</h4>
		<hr>
		<div>
			
		</div>
		<form method="POST" action="?RefrechPanier=1" id="Panier">
			<table>
				<tbody>
					<?php
					if (isset($_SESSION['Panier'])) {
						foreach ($_SESSION['Panier'] as $Product_ID => $Product_Quantity) {
							$Load_Product = $pdo->prepare("SELECT * FROM products WHERE ID = ?");
							$Load_Product->execute([$Product_ID]);

							$Product = $Load_Product->fetch();

							$Total += $Product['Price']*$Product_Quantity;
					?>
					<tr>
						<td><img src="../Asset/Article/<?= $Product['Picture'] ?>"></td>
						<td><p>Marque</p><strong><?= $Product['Name'] ?></strong></td>
						<td><?= number_format(($Product['Price']*$Product_Quantity),2,',',' ') ?> €</td>
						<td><input id="<?= $Product_ID ?>" name="Product[]" type="number" min="1" step="1" value="<?= $Product_Quantity ?>"><br><a href="?delete=<?= $Product_ID ?>">Supprimer</a></td>
						<td style="display: none;"><input name="ID[]" value="<?= $Product_ID ?>"></td>
					</tr>
					<?php 
						}

						$_SESSION['TotalPanier'] = $Total;
					}else{
						?>
					<tr>
						<td>
							<h1>Votre panier est vide</h1>
							<img src="">
						</td>
					</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</form>
	</section>
	<section class="col-3 Total">
		<table>
			<tr>
				<th>Sous-Total</th>
				<td><?= number_format(($Total/1.21),2,',',' ') ?> €</td>
			</tr>
			<tr>
				<th>TVA</th>
				<td><?= number_format(($Total - $Total/1.21),2,',',' ') ?> €</td>
			</tr>
			<tr>
				<th>Total</th>
				<td><?= number_format(($Total),2,',',' ') ?> €</td>
			</tr>
		</table>
		<br>
		<hr>
		<br>
		<a href="Delivery"><button type="button">Passer la commande</button></a>
		<br>
		<img src="../Asset/Avatar/Grain.png">
	</section>
</main>
<script type="text/javascript">
	const inputsNumber = document.querySelectorAll('input[type="number"]');

	inputsNumber.forEach(input => {
	  input.addEventListener('input', (event) => {
	    document.getElementById("Panier").submit();
	  });

	  input.addEventListener('blur', (event) => {
	    document.getElementById("Panier").submit();
	  });

	});

</script>