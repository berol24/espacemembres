	<?php

	// session_start();
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

	if(isset($_SESSION['id']))
	{
	session_unset();

	session_destroy();
	header('location:accueil.php');
	}
	else
	{
		echo 'Vous n\'êtes pas connécté ! ';
	}

