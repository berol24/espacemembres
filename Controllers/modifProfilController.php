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


    $req = $bdd->prepare('SELECT * FROM fruistore.users WHERE username = :username');

    $req->bindvalue(':username', $_POST['username']);
    $req->execute();
    $result = $req->fetch();

    if($result)
    {
      $message = "Le nom d'utilisateur que vous avez choisi est déjà pris";
    }
    else
    {
      $requete = $bdd->prepare('UPDATE fruistore.users SET username = :username, email = :email, telephone = :telephone, adresse = :adresse WHERE id=:id' );

      $requete->bindvalue(':username', $_POST['username']);
      $requete->bindvalue(':email', $_POST['email']);
      $requete->bindvalue(':telephone', $_POST['telephone']);
      $requete->bindvalue(':adresse', $_POST['adresse']);
      $requete->bindvalue(':id', $id);

      $requete->execute();

      // Met à jour les infos de session
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['telephone'] = $_POST['telephone'];
      $_SESSION['adresse'] = $_POST['adresse'];
      header('location:devis_nouveau.php');

    }

  }

}

?>