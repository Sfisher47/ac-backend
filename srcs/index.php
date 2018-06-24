<?php

/* ************************************************************************** */
/*                                                                            */
/*  index.php                                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jan 01 01:00:00 1970                        by elhmn        */
/*   Updated: Sat Jun 23 19:39:58 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

$servername = 'localhost';
$username = 'root';
$password = '';

try
{
	$conn = new PDO("mysql:host$servername;dbname=actions_citoyennes",
					$username, $password);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";
}
catch (PDOException $e)
{
	echo "Connection failed : " . $e->getMessage();
}

$conn->close();

?>
