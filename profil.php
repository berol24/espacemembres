<?php require 'include/header.php'; ?>
<title>Profil</title>
</head><body>
</div>

<?php
// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
if(isset($_SESSION['id']))
{
	?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="profile-card">
                <div class="profile-header">
                    <h3>Mon Profil</h3>
                </div>
                <div class="profile-body">
                    <img src="images/logo-NielsenIQ.png" class="profile-image" alt="Photo de profil">

                    <div class="profile-info">
                        <div class="info-group">
                            <div class="info-item">
                                <label>Nom d'utilisateur</label>
                                <div class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                            </div>
                            <div class="info-item">
                                <label>Adresse email</label>
                                <div class="info-value"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                            </div>
                            <div class="info-item">
                                <label>Téléphone</label>
                                <div class="info-value"><?php echo htmlspecialchars($_SESSION['telephone']); ?></div>
                            </div>
                            <div class="info-item">
                                <label>Adresse</label>
                                <div class="info-value"><?php echo htmlspecialchars($_SESSION['adresse']); ?></div>
                            </div>
                        </div>
                    </div>

                    <a href="modif_profil.php" class="edit-button">
                        Modifier mon profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
}
else {
	header('Location: connexion.php');
	exit();
}
?>
				</body>
				</html>