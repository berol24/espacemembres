<?php

$bdd = new PDO('mysql:dbname = fruistore; host=localhost','root','');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);