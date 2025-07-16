  <?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
  ?>

  <?php include 'include/header.php'; ?>
  <header style=" position: sticky; top: 0; display: flex; justify-content: space-between; align-items: center; padding: 10px 30px; background-color: #f5f5f5; border-bottom: 1px solid #ddd;">

    <div>
        <a href="devis_nouveau.php">
            <img src="images/logo-nielsen.png" alt="logo_nielsen" style="height: 50px;">
        </a>
    </div>

  
    <div style="display: flex; gap: 15px;">
        <?php if (isset($_SESSION['id'])): ?>
            <a href="profil.php" style="text-decoration: none; padding: 8px 15px; background-color: #007bff; color: white; border-radius: 5px;">Mon Profil</a>
            <a href="deconnexion.php" style="text-decoration: none; padding: 8px 15px; background-color: #dc3545; color: white; border-radius: 5px;">Déconnexion</a>
        <?php else: ?>
            <a href="inscription.php" style="text-decoration: none; padding: 8px 15px; background-color: #6c757d; color: white; border-radius: 5px;">Inscription</a>
            <a href="connexion.php" style="text-decoration: none; padding: 8px 15px; background-color: transparent; border: 1px solid #6c757d; color: #6c757d; border-radius: 5px;">Connexion</a>
            <?php endif; ?>
    </div>
</header>
