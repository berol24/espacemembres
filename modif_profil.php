  <?php
// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
  <?php require 'include/header.php'; ?>
  <title>Profil</title>
</head><body>
</div>

<?php
require_once 'Controllers/modifProfilController.php';
?>



<div id="login" class="py-5">
  <h3 class="modif-title" style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; color: #333; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 35%; margin-left: auto; margin-right: auto;">Modification du profil</h3>
  <div class="container">
    <div id="login-row" class="row justify-content-center align-items-center">
      <div id="login-column" class="col-md-6">
        <div id="login-box" class="col-md-12 bg-white p-4 rounded shadow">

          <?php if(isset($message)): ?>
          <div class="alert alert-danger text-center mb-4">
            <?php echo $message; ?>
          </div>
          <?php endif; ?>

          </form>

          <form id="login-form" class="form" action="" method="post">
            <div class="form-group mb-3">
              <label for="username" class="form-label text-dark">Nom d'utilisateur</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Entrez votre nom d'utilisateur" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
            </div>

            <div class="form-group mb-3">
              <label for="email" class="form-label text-dark">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Entrez votre email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
            </div>

            <div class="form-group mb-3">
              <label for="telephone" class="form-label text-dark">Téléphone</label>
              <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="Entrez votre numéro de téléphone" value="<?php echo htmlspecialchars($_SESSION['telephone'] ?? ''); ?>">
            </div>

            <div class="form-group mb-3">
              <label for="adresse" class="form-label text-dark">Adresse</label>
              <input type="text" name="adresse" id="adresse" class="form-control" placeholder="Entrez votre adresse" value="<?php echo htmlspecialchars($_SESSION['adresse'] ?? ''); ?>">
            </div>

            <div class="form-group text-center">
              <input type="submit" name="modification" class="btn btn-primary btn-lg w-100" value="Modifier mon profil">
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



</body>
</html>