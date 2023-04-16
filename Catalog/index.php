<?php 

require '../INC/Header.php';

if (isset($_GET['addPanier'])) {

	$Check_Product = $pdo->prepare("SELECT ID FROM products WHERE ID = ?");
	$Check_Product->execute([$_GET['addPanier']]);
	$Product = $Check_Product->fetch();

	if ($Product) {
		if(!isset($_SESSION['Panier'])) {
		    $_SESSION['Panier'] = array();
		}

		if(isset($_SESSION['Panier'][$Product['ID']])) {
	        $_SESSION['Panier'][$Product['ID']] += 1;
	    } else {
	        $_SESSION['Panier'][$Product['ID']] = 1;
	    }

	    $_SESSION['notification']['message'] = "Article ajouté dans le panier";
	    $_SESSION['notification']['type'] = "success";

	    header('Location: '.$url.'Catalog/');
	    exit;
	}else{
		echo "NOP";
	}
}

?>

<section class="Catalog">
	<?php 
	$Load_Product = $pdo->query("SELECT * FROM products");
	
	while ($Product = $Load_Product->fetch()) {
	?>
	<a href="?view=<?= $Product['ID'] ?>">
		<article class="Article">
			<div class="Tags">
				<div class="New">Nouveau</div>
				<div class="Bestseller">BestSeller</div>
			</div>
			<div class="Image">
				<img src="../Asset/Article/<?= $Product['Picture'] ?>">
			</div>
			<div class="Description">
				<h4><?= number_format(($Product['Price']),2,',',' ') ?> €</h4>
				<p><?= $Product['Name'] ?></p>
				<a href="?addPanier=<?= $Product['ID'] ?>"><button class="btn btn-outline-primary"><i class="fa-solid fa-cart-shopping"></i> 	Ajouter au panier</button></a>
			</div>
		</article>
	</a>
	<?php 
	}
	?>
</section>


<style type="text/css">
	body{
		background-color: #f6f9fe;
	}
</style>