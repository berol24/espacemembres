<?php require 'include/header.php'; ?>
<title>Inscription</title>

<?php
require_once 'Controllers/inscriptionController.php';
?>


<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3>Inscription</h3>
        </div>
        <div class="card-body">
          
          <?php if (isset($message)): ?>
          <div class="alert alert-danger">
            <?php echo $message; ?>
          </div>
          <?php endif; ?>

          <?php if (isset($message1)): ?>
          <div class="alert alert-success">
            <?php echo $message1; ?>
          </div>
          <?php endif; ?>

          <form id="login-form" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="username">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
              <label for="adresse">Adresse</label>
              <input type="text" name="adresse" id="adresse">
            </div>
            <div class="form-group">
              <label for="telephone">Téléphone</label>
              <input type="tel" name="telephone" id="telephone">
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
              <label for="password2">Confirmation du mot de passe</label>
              <input type="password" name="password2" id="password2">
            </div>
            <div class="form-actions">
              <button type="submit" name="inscription">S'inscrire</button>
              <p class="login-link">Vous avez déjà un compte ? <a href="connexion.php">Connectez-vous ici</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


</div></body></html>

