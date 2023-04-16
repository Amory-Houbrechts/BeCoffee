<?php 

require '../INC/Header.php';

?>
<main class="Order">
	<?php 
	if (isset($_GET['View'])) {
		$Load_Order = $pdo->prepare("SELECT * FROM orders WHERE ID = ?");
		$Load_Order->execute([$_GET['View']]);	
		$Order = $Load_Order->fetch();

		$Total = 0;
	?>
	<section class="OrderNumber">
		<h4>Commande <?= $Order['ID'] ?></h4>
		<h6><?= $Order['DateOrder'] ?></h6>
	</section>
	<br>
	<section class="OrderInfo">
		<div class="col-8">
			<article class="Product">
				<h4>Articles</h4>
				<hr>
				<table>
					<tbody>
						<?php 
						$Load_List_Product = $pdo->prepare("SELECT * FROM listproduct WHERE Orders = ?");
						$Load_List_Product->execute([$Order['ID']]);

						while ($List_Product = $Load_List_Product->fetch()) {
							$Load_Product = $pdo->prepare("SELECT * FROM products WHERE ID = ?");
							$Load_Product->execute([$List_Product['Product']]);
							$Product = $Load_Product->fetch();

							$Total += $Product['Price']*$List_Product['Quantity'];
						?>
						<tr>
							<td><img src="../Asset/Article/<?= $Product['Picture'] ?>"></td>
							<td>
								<h6><?= $Product['Name'] ?></h6>
								<p><?= $Product['Reference'] ?></p>
							</td>
							<td><?= number_format(($Product['Price']),2,',',' ') ?> € x <?= $List_Product['Quantity'] ?></td>
							<td><?= number_format(($Product['Price']*$List_Product['Quantity']),2,',',' ') ?> €</td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td></td>
							<td></td>
							<th>Total HTVA<br>TVA<br>Total TTC</th>
							<td><?= number_format(($Total/1.21),2,',',' ') ?> €<br><?= number_format(($Total - $Total/1.21),2,',',' ') ?> €<br><?= number_format(($Total),2,',',' ') ?> €</td>
						</tr>
					</tbody>
				</table>
			</article>
			<article class="Info">
				<h4>Informations</h4>
				<hr>
				<table>
					<tbody>
						<tr>
							<th>NOM Prénom</th>
							<td>HOUBRECHTS Amory</td>
						</tr>
						<tr>
							<th>Adresse</th>
							<td>Rue Joseph Delhalle, 51<br>4520 Wanze<br>BELGIUM</td>
						</tr>
						<tr>
							<th>Mode de paiement</th>
							<td>Bancontact (123**********3219)</td>
						</tr>
					</tbody>
				</table>
			</article>
		</div>
		<div class="col-3">
			<article class="Folow">
				<h4>Suivi</h4>
				<hr>
				<div>
					<img src="../Asset/Avatar/Preparation.png">
					<h6>
						En préparation
					</h6>
				</div>
				<div>
					<img src="../Asset/Avatar/Expedier.png" <?php if ($Order['Status'] < 2) {echo "style='filter: grayscale(100%);'";} ?>>
					<h6>
						Expédier
					</h6>
				</div>
				<div>
					<img src="../Asset/Avatar/Livraison.png" <?php if ($Order['Status'] < 3) {echo "style='filter: grayscale(100%);'";} ?>>
					<h6>
						En cours de livraison
					</h6>
				</div>
				<div>
					<img src="../Asset/Avatar/Livre.png" <?php if ($Order['Status'] < 4) {echo "style='filter: grayscale(100%);'";} ?>>
					<h6>
						Livré
					</h6>
				</div>
			</article>
			<article>
				<h4>Livraison</h4>
				<hr>
				<h6>3272338274903723270</h6>
			</article>
		</div>
	</section>
	<?php 
	}else{
	?>
	<section class="ListOrder">
		<?php 
		$Load_Order = $pdo->prepare('SELECT * FROM orders WHERE User = ?');
		$Load_Order->execute([$_SESSION['auth']['ID']]);

		while($Order = $Load_Order->fetch()){

			if ($Order['Status'] == 1) {
				$State = "En préparation";
			}elseif ($Order['Status'] == 2) {
				$State = "Expédier";
			}elseif ($Order['Status'] == 3) {
				$State = "En cours de livraison";
			}elseif ($Order['Status'] == 4) {
				$State = "Livré";
			}else{
				$State = "Erreur";
			}

			$Load_Payment = $pdo->prepare("SELECT Total FROM payment WHERE ID = ?");
			$Load_Payment->execute([$Order['PaymentID']]);
			$Payment = $Load_Payment->fetch();
		?>
		<article>
			<header>
				<div>
					Commande effecturé le<br>
					<?= $Order['DateOrder'] ?>
				</div>
				<div>
					Total<br>
					<?= number_format(($Payment['Total']),2,',',' ') ?> €
				</div>
				<div>
					Livraison à<br>
				</div>
				<div>
					N° de commande<br>
					<?= $Order['ID'] ?>
				</div>
			</header>
			<main>
				<h4>Statut : <?= $State ?></h4>
				<br>
				<table>
					<tbody>
						<?php 
						$Load_List_Product = $pdo->prepare("SELECT * FROM listproduct WHERE Orders = ?");
						$Load_List_Product->execute([$Order['ID']]);

						while ($List_Porduct = $Load_List_Product->fetch()) {

							$Load_Product = $pdo->prepare("SELECT * FROM products WHERE ID = ?");
							$Load_Product->execute([$List_Porduct['Product']]);
							$Product = $Load_Product->fetch();
						?>
						<tr>
							<td>
								<img src="../Asset/Article/<?= $Product['Picture'] ?>">
							</td>
							<td>
								<h6><?= $Product['Name'] ?></h6>
							</td>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
			</main>
			<footer>
				<a href="?View=<?= $Order['ID'] ?>">Afficher la commande</a>
			</footer>
		</article>
		<br>
		<?php 
		}
		?>
	</section>
	<?php
	}
	?>
</main>