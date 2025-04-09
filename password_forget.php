    <?php require 'include/header.php'; ?>
    <title>Réinitialisation</title>
  </head><body>

    <?php
    if(isset($_POST['password_forget'])){

     function token_random_string($leng=20){

      $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $token = '';
      for($i=0;$i<$leng;$i++){
        $token.=$str[rand(0,strlen($str)-1)];
      }
      return $token;
    }


    if(empty($_POST['email'])|| !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
     $message = "Rentrer une adresse email valide";
   }
   else{

     require('include/start_bdd.php');

     $requete=$bdd->prepare('SELECT * FROM membres.table_membres WHERE email=:email');
     $requete->bindvalue(':email', $_POST['email']);
     $requete->execute();

     $result=$requete->fetch();


     $nombre=$requete->rowCount();

     if($nombre!=1){
      $message = "L'adresse email saisie ne corréspond à aucun utilisateur de notre espace membre";
    }
    else{
      if($result['validation']!=1){

        $token = token_random_string(20);

        $update = $bdd->prepare('UPDATE membres.table_membres SET token=:token WHERE email =:email');
        $update->bindvalue(':token', $token);
        $update->bindvalue(':email',$_POST['email']);
        $update->execute();


        require_once 'sendmail.php';

      }else{
        $token = token_random_string(20);
        $requete1 = $bdd->prepare('SELECT * FROM membres.recup_password WHERE email=:email');
        $requete1->bindvalue(':email', $_POST['email']);
        $requete1->execute();

        $nombre1 = $requete1->rowCount();

        if($nombre1 == 0){

          $requete2 = $bdd->prepare('INSERT INTO membres.recup_password(email,token) VALUES(:email,:token)');
          $requete2->bindvalue(':email',$_POST['email']);
          $requete2->bindvalue(':token', $token);
          $requete2->execute();

        }else{
          $requete3 = $bdd->prepare('UPDATE membres.recup_password SET token=:token WHERE email=:email');
          $requete3->bindvalue(':token', $token);
          $requete3->bindvalue(':email',$_POST['email']);
          $requete3->execute();

        }

        require_once 'sendmail_recup.php';

      }
    }
  }
}



?>

<div id="login" class="py-5">
  <div class="container">
    <h3 class="text-center text-white">Mot de passe oublié</h3>
    <h6 class="text-center text-white mb-4">
      Merci de rentrer votre adresse email ci-dessous, nous vous enverrons des instructions pour réinitialiser votre mot de passe.
    </h6>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-body">

            <?php if (isset($message)): ?>
              <div class="alert alert-danger text-center" role="alert">
                <?= $message; ?>
              </div>
            <?php endif; ?>

            <?php if (isset($message1)): ?>
              <div class="alert alert-success text-center" role="alert">
                <?= $message1; ?>
              </div>
            <?php endif; ?>

            <form id="login-form" method="post" action="">
              <div class="form-group mb-3">
                <label for="email" class="form-label text-info">Votre adresse Email :</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="tf1@domaine.com" required>
              </div>

              <div class="form-group text-center">
                <input type="submit" name="password_forget" class="btn btn-info btn-md" value="Réinitialiser mon mot de passe">
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
