<?php

if(isset($_POST['connexion']))
{

  $email    = $_POST['email'];
  $password =$_POST['password'];


  require_once 'include/start_bdd.php';

  $requete = $bdd->prepare('SELECT * FROM fruistore.users WHERE email=:email');
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

          $update = $bdd->prepare('UPDATE fruistore.users SET token=:token WHERE email=:email');
          $update->bindvalue(':token', $token);
          $update->bindvalue(':email', $_POST['email']);
          $update->execute();

          require_once 'sendmail.php';

  }else{
    // verification du mot de passe
    $passwordIsOk = password_verify($password, $result['password']);

    if($passwordIsOk){
      // session_start();
      if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
      $_SESSION['id'] = $result['id'];
      $_SESSION['username'] = $result['username'];
      $_SESSION['email'] = $email;
      $_SESSION['adresse'] = $result['adresse'];
      $_SESSION['telephone'] = $result['telephone'];

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

      header('location:devis_nouveau.php');

    }
    else{
      $message =  "Merci de rentrer un mot de passe valide!";
    }
  }

}

?>
