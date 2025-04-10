	
<?php
session_start();
?>

<?php include 'include/header.php'; ?>

<main class="d-flex flex-column justify-content-center align-items-center text-center min-vh-100 bg-dark text-white">
    <img src="images/logo_unedic.png" alt="logo_unedic" class="mb-4" style="width: 150px; height: 150px;">

    <?php if (isset($_SESSION['id'])): ?>
        <h1 class="mb-3">Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
        <h4 class="mb-4">Votre plateforme de divertissement préférée</h4>
        <div>
            <a href="profil.php" class="btn btn-primary btn-lg mx-2">Mon Profil</a>
            <a href="deconnexion.php" class="btn btn-danger btn-lg mx-2">Déconnexion</a>
        </div>
    <?php else: ?>
        <h1 class="mb-3">Bienvenue chez Unédic</h1>
        <h4 class="mb-4">Votre plateforme de divertissement préférée</h4>
        <div>
            <a href="inscription.php" class="btn btn-light btn-lg mx-2">Inscription</a>
            <a href="connexion.php" class="btn btn-outline-light btn-lg mx-2">Connexion</a>
        </div>
    <?php endif; ?>
</main>


