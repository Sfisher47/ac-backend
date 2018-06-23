<?php

/* ************************************************************************** */
/*                                                                            */
/*  sign_up_back.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 10:47:03 2018                        by elhmn        */
/*   Updated: Sat Jun 23 11:59:26 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
require_once('./model/Users.class.php');

//first check that the sent variables were correct

try
{
	$bdd = new PDO("mysql:host=localhost;dbname=actions", "root", getenv('DBPASSWORD'), array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	echo "Error : ".$e->getMessage();
}
var_dump($bdd); //DEBUG

/*
$req = $bdd->prepare('INSERT INTO users(lastName, firstName, email, password) VALUES(:firstName, :lastName, :email, :password)');

$req->execute(array('firstName' => $_POST['firstName'], 'lastName' => $_POST['lastName'], $_POST['email'], $_POST['password']));
*/

?>
