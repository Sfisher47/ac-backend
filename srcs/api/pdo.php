<?php

/* ************************************************************************** */
/*                                                                            */
/*  pdo.php                                                                   */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Thu Jun 28 13:24:43 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

	$host = '127.0.0.1';
	$username = 'bmbarga';
	$password = 'test';
	$db_name = 'actions_citoyennes';

// 	for Unix based system running on socket mode
	$dsn = 'mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock'. ';dbname=' . $db_name;
// 	else
// 	$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

	try
	{
		$pdo = new PDO($dsn, $username, $password);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

		#PRDO QUERY
// 		$stmt = $pdo->query('SELECT * FROM Users');

// 		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
// 		{
// 			echo $row['login'] . PHP_EOL;
// 			print_r($row);
// 		}

		$login = 'baba';
		$email = 'test@email.com';
		$password = 'jesuiscon';
		$signup_date = 'help date';
		$gender = 'male';

		$get = 'SELECT * FROM Users';
		$insert = "INSERT INTO Users (login, email, password,"
				. "signup_date, gender)"
				. " VALUES(:login, :email, :password, :signup_date, :gender)";

		$stmt_insert = $pdo->prepare($insert);
		$stmt_get = $pdo->prepare($get);

		$stmt_insert->execute(['login' => $login,
			'email' => $email,
			'password' => $password,
			'signup_date' => $signup_date,
			'gender' => $gender]);

		echo 'Data inserted ' . PHP_EOL;

		$stmt_get->execute();
		$posts = $stmt_get->fetchAll(PDO::FETCH_ASSOC);

		foreach ($posts as $post)
		{
			print_r($post);
			echo PHP_EOL;
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed : " . $e->getMessage();
	}

?>
