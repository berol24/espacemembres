  <?php require 'include/header.php'; ?>
    <title>Réinitialisation</title>
  </head><body>

<?php

if($_GET){

	if(isset($_GET['email'])){
		$email = $_GET['email'];
	}
	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}

	if(!empty($email) && !empty($token)){

		require_once('include/start_bdd.php');

		$requete = $bdd->prepare('SELECT * FROM membres.recup_password WHERE email=:email AND token=:token');

		$requete->bindvalue(':email', $email);
		$requete->bindvalue(':token', $token);

		$requete->execute();

		$nombre = $requete->rowCount();

		if($nombre!=1){
			header('Location:connexion.php');
		}else{

			if(isset($_POST['new_password'])){

				if(empty($_POST['password']) || $_POST['password']!=$_POST['password2']){
					$message = "Rentrer un mot de passse valide";
				}
				else{
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

					$requete = $bdd->prepare('UPDATE membres.table_membres SET password=:password WHERE email=:email');

					$requete->bindvalue(':email',$email);
					$requete->bindvalue('password', $password);

					$result = $requete->execute();

					if($result){
						echo"<script type =\"text/javascript\">
						alert('Votre mot de passe est bien réinitialisé');
						document.location.href='connexion.php';
					</script>";

				}else{
					
					header('Location:connexion.php');
				}
			}
		}

	}

}

}else{
	header('Location:inscription.php');
}

?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6">
      
      <div class="text-center mb-4">
        <h3>Nouveau mot de passe</h3>
        <p class="text-light">Merci de rentrer votre nouveau mot de passe</p>
      </div>

      <div class="card shadow rounded">
        <div class="card-body">

          <?php if (isset($message)): ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>

          <form action="" method="post">
            <div class="mb-3">
              <label for="password" class="form-label text-primary">Votre nouveau mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Nouveau mot de passe">
            </div>

            <div class="mb-3">
              <label for="password2" class="form-label text-primary">Confirmation du mot de passe</label>
              <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirmer votre mot de passe">
            </div>

            <div class="d-grid">
              <button type="submit" name="new_password" class="btn btn-primary">Valider</button>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>

 	
  </body>
  </html>

