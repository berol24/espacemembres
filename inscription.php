<?php require 'include/header.php'; ?>
<title>Inscription</title>


<?php

//Si l'utilisateur a validé son formulaire d'inscription
if (isset($_POST['inscription'])) {

  if (empty($_POST['username']) || !preg_match('/[a-zA-Z0-9]+/', $_POST['username'])) {
    $message = 'Votre username doit être une chaine de caractéres (alphanumérique) !';
  } elseif (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $message = 'Rentrer une adresse email valide !';
  } elseif (empty($_POST['password']) || $_POST['password'] != $_POST['password2']) {
    $message = "Rentrer un mot de passe valide";
  } else {

    //Connexion à la base de données
    require_once 'include/start_bdd.php';

    //Selection de tous les utilisateurs, s'ils existent, ayant le username saisi dans le formulaire
    $req = $bdd->prepare('SELECT * FROM membres.table_membres WHERE username = :username');

    $req->bindvalue(':username', $_POST['username']);
    $req->execute();
    $result = $req->fetch();

    //Selection de tous les utilisateurs, s'ils existent, ayant l'email saisi dans le formulaire
    $req1 = $bdd->prepare('SELECT * FROM membres.table_membres WHERE email = :email');

    $req1->bindvalue(':email', $_POST['email']);
    $req1->execute();
    $result1 = $req1->fetch();

    if ($result) {
      $message = "Le nom d'utilisateur que vous avez choisi exite déjà";
    } elseif ($result1) {
      $message = " l'adresse email existe déjà";
    } else {
      //Fonction pour générer aléatoirement une chaine de caractères 
      function token_random_string($leng = 20)
      {

        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $leng; $i++) {
          $token .= $str[rand(0, strlen($str) - 1)];
        }
        return $token;
      }

      //Appel de la focntion token_random_string et enregistrement du résultat dans la variable $token
      $token = token_random_string(20);

      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $requete = $bdd->prepare('INSERT INTO membres.table_membres(username, email, password, token) 
            VALUES(:username, :email, :password, :token)');

      $requete->bindvalue(':username', $_POST['username']);
      $requete->bindvalue(':email', $_POST['email']);
      $requete->bindvalue(':password', $password);
      $requete->bindvalue(':token', $token);

      $requete->execute();

      //Inclusion du fichier sendmail.php qui permet d'envoyer le mail de confirmation
      require_once 'sendmail.php';


    }
  }
}

?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-primary text-white text-center">
          <h3 class="mb-0">Inscription</h3>
        </div>
        <div class="card-body">
          
          <?php if (isset($message)): ?>
          <div class="alert alert-danger text-center">
            <?php echo $message; ?>
          </div>
          <?php endif; ?>

          <?php if (isset($message1)): ?>
          <div class="alert alert-success text-center">
            <?php echo $message1; ?>
          </div>
          <?php endif; ?>

          <form id="login-form" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Adresse Email</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3">
              <label for="password2" class="form-label">Confirmation du mot de passe</label>
              <input type="password" name="password2" id="password2" class="form-control">
            </div>
            <div class="d-grid gap-2">
              <button type="submit" name="inscription" class="btn btn-primary">S'inscrire</button>
              <p class="text-center mt-3">Vous avez déjà un compte ? <a href="connexion.php">Connectez-vous ici</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div></body></html>

