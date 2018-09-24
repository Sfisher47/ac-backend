<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserPostUtilities.class.php                                               */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Aug 05 09:27:59 2018                        by bmbarga      */
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
	
	public static function	IsEmailValid($temp_email)
	{ 
		######## Three functions to HELP ######## 
		function valid_dot_pos($email)
		{ 
			$str_len = strlen($email); 
			for ($i=0; $i<$str_len; $i++)
			{ 
				$current_element = $email[$i]; 
				if ($current_element == "." && ($email[$i+1] == "."))
				{ 
					return false; 
					break; 
				}
			} 
			return true; 
		}

		function	valid_local_part($local_part)
		{ 
			if (preg_match("/[^a-zA-Z0-9-_@.!#$%&'*\/+=?^`{\|}~]/", $local_part))
			{ 
				return false; 
			} 
			else
			{ 
				return true; 
			} 
		}

		function	valid_domain_part($domain_part)
		{ 
			if (preg_match("/[^a-zA-Z0-9@#\[\].]/", $domain_part))
			{ 
				return false; 
			} 
			elseif (preg_match("/[@]/", $domain_part) && preg_match("/[#]/", $domain_part))
			{ 
				return false; 
			} 
			elseif (preg_match("/[\[]/", $domain_part) || preg_match("/[\]]/", $domain_part))
			{ 
				$dot_pos = strrpos($domain_part, "."); 
				if (($dot_pos < strrpos($domain_part, "]")) || (strrpos($domain_part, "]") < strrpos($domain_part, "[")))
				{ 
					return true; 
				} 
				elseif (preg_match("/[^0-9.]/", $domain_part))
				{ 
					return false; 
				} 
				else
				{ 
					return false; 
				} 
			} 
			else
			{ 
				return true; 
			} 
		}

		// trim() the entered E-Mail 
		$str_trimmed = trim($temp_email); 
		// find the @ position 
		$at_pos = strrpos($str_trimmed, "@"); 
		// find the . position 
		$dot_pos = strrpos($str_trimmed, "."); 
		// this will cut the local part and return it in $local_part 
		$local_part = substr($str_trimmed, 0, $at_pos); 
		// this will cut the domain part and return it in $domain_part 
		$domain_part = substr($str_trimmed, $at_pos); 
		if (!isset($str_trimmed) || is_null($str_trimmed) || empty($str_trimmed) || $str_trimmed == "")
		{ 
			//$this->email_status = "You must insert something"; 
			return false; 
		} 
		elseif (!valid_local_part($local_part))
		{ 
			//$this->email_status = "Invalid E-Mail Address"; 
			return false; 
		} 
		elseif (!valid_domain_part($domain_part))
		{ 
			//$this->email_status = "Invalid E-Mail Address"; 
			return false; 
		} 
		elseif ($at_pos > $dot_pos)
		{ 
			//$this->email_status = "Invalid E-Mail Address"; 
			return false; 
		} 
		elseif (!valid_local_part($local_part)) { 
			//$this->email_status = "Invalid E-Mail Address"; 
			return false; 
		} 
		elseif (($str_trimmed[$at_pos + 1]) == ".") { 
			//$this->email_status = "Invalid E-Mail Address"; 
			return false; 
		} 
		elseif (!preg_match("/[(@)]/", $str_trimmed) || !preg_match("/[(.)]/", $str_trimmed)) { 
			//$this->email_status = "Invalid E-Mail Address"; 
			return false; 
		} 
		else { 
			//$this->email_status = ""; 
			return true; 
		} 
		
	}

};

?>
