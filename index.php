<?php require 'include/header.php'; ?>	
	<?php 
	session_start();
	if(isset($_SESSION['id'])){
	?>
	<div class="container text-center mt-5">
		<img src="images/logo_tf1.png" alt="logo_tf1" width="150" height="150" class="mb-4">
		<h1 class="text-white mb-4">Bienvenue <?php echo $_SESSION['username']; ?> !</h1>
		<h3 class="text-white mb-4">Votre plateforme de divertissement préférée</h3>
		<a href="profil.php" class="btn btn-primary btn-lg mx-2" style="background-color: #318CE7;">Mon Profil</a>
		<a href="deconnexion.php" class="btn btn-danger btn-lg mx-2" style="background-color: #FF0000;">Déconnexion</a>
	</div>
	<?php 
	}else{
		?>
		
	<title>Accueil</title>
	</head><body>
	</div>
	<div class="container text-center mt-5">
		<img src="images/logo_tf1.png" alt="logo_tf1" width="150" height="150" class="mb-4">
		<h1 class="text-white mb-4">Bienvenue chez TF1</h1>
		<h3 class="text-white mb-4">Votre plateforme de divertissement préférée</h3>
		<a href="inscription.php" class="btn btn-light btn-lg">Inscription</a>
		<a href="connexion.php" class="btn btn-light btn-lg">Connexion</a>
	</div>
<?php 
	}
?>

	
	