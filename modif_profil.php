  <?php
session_start();
?>
  <?php require 'include/header.php'; ?>
  <title>Profil</title>
</head><body>
</div>

<?php


if(isset($_POST['modification']) AND isset($_SESSION['id']))
{
  $id = $_SESSION['id'];

  if(empty($_POST['username']) || !preg_match('/[a-zA-Z0-9]+/', $_POST['username']))
  {
    $message = 'Votre username doit être une chaine de caractéres (alphanumérique) !';
  }
  elseif(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
  {
    $message = "Veuillez entrer une adresse email valide";
  } 
  // elseif(empty($_POST['password']) || $_POST['password'] != $_POST['password2'])
  // {
  //   $message = "Rentrer un mot de passe valide";
  // }
  else
  {
    require_once 'include/start_bdd.php';


    $req = $bdd->prepare('SELECT * FROM membres.table_membres WHERE username = :username');

    $req->bindvalue(':username', $_POST['username']);
    $req->execute();
    $result = $req->fetch();

    if($result)
    {
      $message = "Le nom d'utilisateur que vous avez choisi est déjà pris";
    }
    else
    {
      $requete = $bdd->prepare('UPDATE membres.table_membres SET username = :username, email = :email WHERE id=:id' );

      $requete->bindvalue(':username', $_POST['username']);
      $requete->bindvalue(':email', $_POST['email']);
      $requete->bindvalue(':id', $id);

      $requete->execute();

 // Met à jour les infos de session
$_SESSION['username'] = $_POST['username'];
$_SESSION['email'] = $_POST['email'];
      header('location:index.php');

    }

  }

}

?>

<div id="login" class="py-5">
  <h3 class="text-center text-primary mb-4">Modification du profil</h3>
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