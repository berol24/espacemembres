  <?php require 'include/header.php'; ?>
    <title>Réinitialisation</title>
  </head><body>

<?php
require_once 'Controllers/newPasswordController.php';
?>


<div class="reset-password-container">
    <div class="reset-password-wrapper">
      
      <div class="reset-password-header">
        <h3>Nouveau mot de passe</h3>
        <p>Merci de rentrer votre nouveau mot de passe</p>
      </div>

      <div class="reset-password-card">
        <div class="reset-password-content">

          <?php if (isset($message)): ?>
            <div class="alert-message" role="alert">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>

          <form action="" method="post">
            <div class="form-group">
              <label for="password">Votre nouveau mot de passe</label>
              <input type="password" name="password" id="password" placeholder="Nouveau mot de passe">
            </div>

            <div class="form-group">
              <label for="password2">Confirmation du mot de passe</label>
              <input type="password" name="password2" id="password2" placeholder="Confirmer votre mot de passe">
            </div>

            <div class="form-submit">
              <button type="submit" name="new_password">Valider</button>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>


 	
  </body>
  </html>

