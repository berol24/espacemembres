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

		$requete = $bdd->prepare('SELECT * FROM fruistore.recup_password WHERE email=:email AND token=:token');

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

					$requete = $bdd->prepare('UPDATE fruistore.users SET password=:password WHERE email=:email');

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