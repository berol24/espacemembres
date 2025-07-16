<?php

//Si l'utilisateur a validé son formulaire d'inscription
if (isset($_POST['inscription'])) {

  if (empty($_POST['username']) || !preg_match('/[a-zA-Z0-9]+/', $_POST['username'])) {
    $message = 'Votre username doit être une chaine de caractéres (alphanumérique) !';
  } elseif (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $message = 'Rentrer une adresse email valide !';
  } elseif (empty($_POST['password']) || $_POST['password'] != $_POST['password2']) {
    $message = "Rentrer un mot de passe valide";
  } elseif (empty($_POST['adresse'])) {
    $message = "L'adresse est obligatoire";
  } elseif (empty($_POST['telephone']) || !preg_match('/^[0-9]{10}$/', $_POST['telephone'])) {
    $message = "Le numéro de téléphone doit contenir 10 chiffres";
  } else {

    //Connexion à la base de données
    require_once 'include/start_bdd.php';

    //Selection de tous les utilisateurs, s'ils existent, ayant le username saisi dans le formulaire
    $req = $bdd->prepare('SELECT * FROM fruistore.users WHERE username = :username');

    $req->bindvalue(':username', $_POST['username']);
    $req->execute();
    $result = $req->fetch();

    //Selection de tous les utilisateurs, s'ils existent, ayant l'email saisi dans le formulaire
    $req1 = $bdd->prepare('SELECT * FROM fruistore.users WHERE email = :email');

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

      $requete = $bdd->prepare('INSERT INTO fruistore.users(username, email, password, token, adresse, telephone) 
            VALUES(:username, :email, :password, :token, :adresse, :telephone)');

      $requete->bindvalue(':username', $_POST['username']);
      $requete->bindvalue(':email', $_POST['email']);
      $requete->bindvalue(':password', $password);
      $requete->bindvalue(':token', $token);
      $requete->bindvalue(':adresse', $_POST['adresse']);
      $requete->bindvalue(':telephone', $_POST['telephone']);

      $requete->execute();

      //Inclusion du fichier sendmail.php qui permet d'envoyer le mail de confirmation
      require_once 'sendmail.php';


    }
  }
}

?>
