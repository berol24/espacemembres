    <?php require 'include/header.php'; ?>
    <title>Réinitialisation</title>
  </head><body>

<?php
require_once 'Controllers/passwordForgetController.php';

?>


<link rel="stylesheet" href="css/password_forget.css">



<div id="login">
  <div class="container">
    <h3 style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; color: #333; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 48%; margin-left: auto; margin-right: auto;">Mot de passe oublié</h3>
    <h6>
      Merci de rentrer votre adresse email ci-dessous, nous vous enverrons des instructions pour réinitialiser votre mot de passe.
    </h6>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <?php if (isset($message)): ?>
            <div class="alert alert-danger">
              <?= $message; ?>
            </div>
          <?php endif; ?>

          <?php if (isset($message1)): ?>
            <div class="alert alert-success">
              <?= $message1; ?>
            </div>
          <?php endif; ?>

          <form id="login-form" method="post" action="">
            <div class="form-group">
              <label for="email">Votre adresse Email :</label>
              <input type="email" name="email" id="email" placeholder="nielseniq@domaine.com" required>
            </div>

            <div class="form-group text-center">
              <input type="submit" name="password_forget" value="Réinitialiser mon mot de passe">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
