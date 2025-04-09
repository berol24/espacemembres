<?php require 'include/header.php'; ?>
<?php

if(isset($_POST['connexion']))
{

  $email    = $_POST['email'];
  $password =$_POST['password'];


  require_once 'include/start_bdd.php';

  $requete = $bdd->prepare('SELECT * FROM membres.table_membres WHERE email=:email');
  $requete->execute(array('email'=>$email ));
  $result = $requete->fetch();

  if(!$result){
    $message = "Merci de rentrer une adresse email valide";
  }
  elseif($result['validation']==0){

      function token_random_string($leng=20){

            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for($i=0;$i<$leng;$i++){
              $token.=$str[rand(0,strlen($str)-1)];
            }
            return $token;
          }

          $token = token_random_string(20);

          $update = $bdd->prepare('UPDATE membres.table_membres SET token=:token WHERE email=:email');
          $update->bindvalue(':token', $token);
          $update->bindvalue(':email', $_POST['email']);
          $update->execute();

          require_once 'sendmail.php';

  }else{
    // verification du mot de passe
    $passwordIsOk = password_verify($password, $result['password']);

    if($passwordIsOk){
      session_start();
      $_SESSION['id'] = $result['id'];
      $_SESSION['username'] = $result['username'];
      $_SESSION['email'] = $email;

//Code pour l'option se souvenir de moi
       if(isset($_POST['sesouvenir']))
      {
       setcookie("email", $_POST['email']);
       setcookie("password", $_POST['password']);
     }
     else
     {
       if(isset($_COOKIE['email']))
       {
        setcookie($_COOKIE['email'], "");

      }
      if(isset($_COOKIE['password']))
      {
        setcookie($_COOKIE['password'], "");
      }

    }

      header('location:index.php');

    }
    else{
      $message =  "Merci de rentrer un mot de passe valide!";
    }
  }

}

?>


<div id="login">
  <h3 class="text-center text-white pt-5">Connexion</h3>
  <div class="container">
    <div id="login-row" class="row justify-content-center align-items-center">
      <div id="login-column" class="col-md-6">
        <div id="login-box" class="col-md-12 bg-white p-4 rounded shadow">

          <?php if(isset($message)): ?>
          <div class="alert alert-danger text-center">
            <?php echo $message; ?>
          </div>
          <?php endif; ?>

          <form id="login-form" class="form" action="" method="post">
            <h3 class="text-center text-primary mb-4">Formulaire de connexion</h3>
            
            <div class="form-group mb-3">
              <label for="email" class="form-label">Adresse Email:</label>
              <input type="email" name="email" id="email" class="form-control" value="<?php if(isset($_COOKIE['email'])) {echo $_COOKIE['email'];} ?>">
            </div>

            <div class="form-group mb-3">
              <label for="password" class="form-label">Mot de passe:</label>
              <input type="password" name="password" id="password" class="form-control" value="<?php if(isset($_COOKIE['password'])) {echo $_COOKIE['password'];} ?>">
            </div>

            <div class="form-check mb-3">
              <input type="checkbox" name="sesouvenir" id="sesouvenir" class="form-check-input">
              <label for="sesouvenir" class="form-check-label">Se souvenir de moi</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <input type="submit" name="connexion" class="btn btn-primary" value="Se connecter">
              <a href="password_forget.php" class="text-decoration-none">Mot de passe oublié</a>
            </div>

            <div class="text-center mt-3">
              <p>Pas encore de compte ? <a href="inscription.php" >Inscrivez-vous ici</a></p>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>


