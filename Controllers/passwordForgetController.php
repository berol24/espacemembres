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

     $requete=$bdd->prepare('SELECT * FROM fruistore.users WHERE email=:email');
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

        $update = $bdd->prepare('UPDATE fruistore.users SET token=:token WHERE email =:email');
        $update->bindvalue(':token', $token);
        $update->bindvalue(':email',$_POST['email']);
        $update->execute();


        require_once 'sendmail.php';

      }else{
        $token = token_random_string(20);
        $requete1 = $bdd->prepare('SELECT * FROM fruistore.recup_password WHERE email=:email');
        $requete1->bindvalue(':email', $_POST['email']);
        $requete1->execute();

        $nombre1 = $requete1->rowCount();

        if($nombre1 == 0){

          $requete2 = $bdd->prepare('INSERT INTO fruistore.recup_password(email,token) VALUES(:email,:token)');
          $requete2->bindvalue(':email',$_POST['email']);
          $requete2->bindvalue(':token', $token);
          $requete2->execute();

        }else{
          $requete3 = $bdd->prepare('UPDATE fruistore.recup_password SET token=:token WHERE email=:email');
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