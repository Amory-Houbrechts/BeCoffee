<?php
date_default_timezone_set('Europe/Brussels');

$url = "http://".$_SERVER['HTTP_HOST']."/BeCoffee/";

require 'DB.php';

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (session_status() == PHP_SESSION_NONE) {
      session_start();
}

$NB_Product = 0;
if (isset($_SESSION['Panier'])) {
	foreach ($_SESSION['Panier'] as $ProductPanier) {
		$NB_Product += $ProductPanier;
	}
}else{
	$NB_Product = 0;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?= $url;?>CSS/Styles.css">
</head>
<body>
	<div class="notification-container">
	  <?php if (isset($_SESSION['notification']) && !empty($_SESSION['notification'])) { ?>
	    <div id="notification-alert" class="alert alert-<?php echo $_SESSION['notification']['type']; ?> alert-dismissible fade show" role="alert" style="position: fixed; width: 85%; z-index: 99; left: 50%; top: 20px; transform: translate(-50%);">
	      <?php echo $_SESSION['notification']['message']; ?>
	      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <?php unset($_SESSION['notification']); ?>
	  <?php } ?>
	</div>
	<nav>
	  <ul>
	    <li><a href="<?= $url;?>">Accueil</a></li>
	    <li><a href="<?= $url;?>Catalog/">Nos produits</a></li>
	    <li><a href="<?= $url;?>Panier/">Panier<span class="badge"><?= $NB_Product ?></span></a></li>
	    <?php
	    if(isset($_SESSION['auth'])) {
	    ?>
	    <li>
	      <a href="#"><?= $_SESSION['auth']['Surname']." ".$_SESSION['auth']['Name'] ?></a>
	      <ul>
	        <li><a href="<?= $url;?>User/Account">Mon Compte</a></li>
	        <li><a href="<?= $url;?>User/Order">Mes Commandes</a></li>
	        <li><a href="<?= $url;?>User/Logout">Me deconnecter</a></li>
	      </ul>
	    </li>
	    <?php
	    }else{
	    	?>
	    <li><a href="<?= $url;?>User/Login">Connexion</a></li>
	    <li><a href="<?= $url;?>User/Register">Inscription</a></li>
	    	<?php
	    }
	    ?>
	  </ul>
	</nav>
<script type="text/javascript">
	function setActive() {
	  var links = document.getElementsByTagName('a');
	  for (var i = 0; i < links.length; i++) {
	    links[i].onclick = function() {
	      var element = this.parentNode;
	      if (element.classList.contains('active')) {
	        element.classList.remove('active');
	      } else {
	        element.classList.add('active');
	      }
	    }
	  }
	}

	window.onload = setActive;

</script>