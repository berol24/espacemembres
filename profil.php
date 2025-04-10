<?php require 'include/header.php'; ?>
<title>Profil</title>
</head><body>
</div>

<?php
session_start(); 
if(isset($_SESSION['id']))
{
	?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h3 class="mb-0">Mon Profil</h3>
                </div>
                <div class="card-body text-center p-5">
                    <img src="images/logo_unedic.png" class=" mb-4 img-thumbnail" alt="Photo de profil">

                    <div class="row text-start">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Nom d'utilisateur</label>
                            <div class="form-control bg-body-secondary"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Adresse email</label>
                            <div class="form-control bg-body-secondary"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                        </div>
                    </div>

                    <a href="modif_profil.php" class="btn btn-primary mt-4">
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