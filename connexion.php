<?php require 'include/header.php'; ?>
<?php
require_once 'Controllers/connexionController.php';
?>



<div id="login">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 style="color: white;height: 5px;">Connexion</h3>
          </div>
          <div class="card-body">
            <?php if(isset($message)): ?>
            <div class="alert alert-danger">
              <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <form id="login-form" class="form" action="" method="post">
              <div class="form-group">
                <label for="email">Adresse Email:</label>
                <input type="email" name="email" id="email" value="<?php if(isset($_COOKIE['email'])) {echo $_COOKIE['email'];} ?>">
              </div>

              <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" value="<?php if(isset($_COOKIE['password'])) {echo $_COOKIE['password'];} ?>">
              </div>

              <div class="form-group">
                <div class="form-check" style="display: flex; align-items: center; margin: 10px 0;">
                  <input type="checkbox" name="sesouvenir" id="sesouvenir" style="margin-right: 8px; width: 10px;">
                  <label for="sesouvenir" style="margin: 0;">Se souvenir de moi</label>
                </div>
              </div>

              <div class="form-actions">
                <button type="submit" name="connexion">Se connecter</button>
                <a href="password_forget.php" class="forgot-password">Mot de passe oublié</a>
              </div>

              <div class="login-link">
                <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>


