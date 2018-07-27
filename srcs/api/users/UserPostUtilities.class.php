<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserPostUtilities.class.php                                               */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jul 27 12:12:49 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */


class		UserPostUtilities
{
	public static function		SanitizeData($data)
	{
		if (!$data)
		{
			internal_error("data set to null", __FILE__, __LINE__);
			return(null);
		}

		if (property_exists($data, 'login'))
			$data->login = htmlspecialchars(strip_tags(($data->login)));

		if (property_exists($data, 'firstname'))
			$data->firstname = htmlspecialchars(strip_tags(($data->firstname)));

		if (property_exists($data, 'lastname'))
			$data->lastname = htmlspecialchars(strip_tags(($data->lastname)));

		if (property_exists($data, 'password'))
			$data->password = htmlspecialchars(strip_tags(($data->password)));

		if (property_exists($data, 'email'))
			$data->email = htmlspecialchars(strip_tags(($data->email)));

		if (property_exists($data, 'city'))
			$data->city = htmlspecialchars(strip_tags(($data->city)));

		if (property_exists($data, 'country'))
			$data->country = htmlspecialchars(strip_tags(($data->country)));

		if (property_exists($data, 'bio'))
			$data->bio = htmlspecialchars(strip_tags(($data->bio)));

		if (property_exists($data, 'picture'))
			$data->picture = htmlspecialchars(strip_tags(($data->picture)));

		if (property_exists($data, 'phonenumber'))
			$data->phonenumber = htmlspecialchars(strip_tags(($data->phonenumber)));

		if (property_exists($data, 'signupdate'))
			$data->signupdate = htmlspecialchars(strip_tags(($data->signupdate)));

		if (property_exists($data, 'gender'))
			$data->gender = htmlspecialchars(strip_tags(($data->gender)));

		return ($data);
	}

	public static function		CanBePosted($data, $db, $tableName)
	{
		if (!$data)
		{
			internal_error("data set to null", __FILE__, __LINE__);
			return(false);
		}
		if (!$db)
		{
			internal_error("db set to null", __FILE__, __LINE__);
			return(false);
		}

		if (!($conn = $db->Connect()))
		{
			internal_error("conn set to null", __FILE__, __LINE__);
			return (false);
		}
		//Check if login already exists
		$queryLogin = "SELECT login FROM $tableName WHERE login=:login";
		try
		{
			$stmtLogin = $conn->prepare($queryLogin);
			$stmtLogin->bindParam(':login', $data->login);
			$stmtLogin->execute();
			$ret = $stmtLogin->fetchAll(PDO::FETCH_ASSOC);
			if ($ret)
			{
				internal_error("login already exists", __FILE__, __LINE__);
				return false;
			}
		}
		catch(Exception $e)
		{
			internal_error("stmtLogin : " . $e->getMessage(),
						__FILE__, __LINE__);
			return (false);
		}

		//Check if email already exists
		$queryEmail = "SELECT email FROM $tableName WHERE email=:email";
		try
		{
			$stmtEmail = $conn->prepare($queryEmail);
			$stmtEmail->bindParam(':email', $data->email);
			$stmtEmail->execute();
			$ret = $stmtEmail->fetchAll(PDO::FETCH_ASSOC);
			if ($ret)
			{
				internal_error("email already exists", __FILE__, __LINE__);
				return false;
			}
		}
		catch(Exception $e)
		{
			internal_error("stmtEmail : " . $e->getMessage(),
						__FILE__, __LINE__);
			return (false);
		}
		return (true);
	}

};

?>
