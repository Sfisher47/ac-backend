<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jul 27 14:22:18 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	class		UserRequest implements IRequestHandler
	{
		private			$table = "Users";
		public static	$verbose = false;

// 		contructor
		public function __construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
		}

// 		destructor
		public function __destruct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " destructor called !" . PHP_EOL;
			}
		}

		//IRequestHandler function override
		public function		Get($kwargs)
		{
			if (!$kwargs
					|| !is_array($kwargs))
			{
				internal_error('kwargs not array or set to null',
								__FILE__, __LINE__);
				return (-1);
			}
			$id = $kwargs['id'];
			$db = $kwargs['db'];

			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
			$query = (!$id) ? "SELECT * FROM " . $this->table
									: "SELECT * FROM " . $this->table
										. " WHERE id = $id";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (!$ret)
			{
				echo '{"response" : "nothing found"}';
				return (0);
			}
			echo json_encode($ret); // Debug
		}

		public function		Post($kwargs)
		{
			if (!$kwargs
					|| !is_array($kwargs))
			{
				internal_error('kwargs not array or set to null',
								__FILE__, __LINE__);
				return (-1);
			}

			$db = $kwargs['db'];

			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}

			if (!$GLOBALS['ac_script'])
			{
				$data = json_decode(file_get_contents("php://input"));
				if (!$data)
				{
					internal_error("data set to null", __FILE__, __LINE__);
					http_error(204); //No Content
					return (-1);
				}
			}
			else
			{
				$data = json_decode('{
										"login" : "user1",
										"firstname" : "Boris",
										"lastname" : "Mbarga",
										"password" : "password",
										"email" : "bmbarga@email.com",
										"city" : "Yaounde",
										"country" : "Cameroun",
										"bio" : "Je suis con",
										"picture" : "",
										"phonenumber" : "092299344",
										"signupdate" : "10",
										"gender" : "male"
									}');
			}
			$data = UserPostUtilities::SanitizeData($data);

			//check credentials
			if (empty($data->password))
			{
				http_error(400, "Empty password");
				return (-1);
			}

			if (!UserPostUtilities::CanBePosted($data, $db, $this->table))
			{
				http_error(409); //Resource exists
				return (-1);
			}

			$query = 'INSERT INTO ' . $this->table
					. ' SET
						login = :login,
						firstname = :firstname,
						lastname = :lastname,
						password = :password,
						email = :email,
						city = :city,
						country = :country,
						bio = :bio,
						picture = :picture,
						phonenumber = :phonenumber,
						signup_date = :signupdate,
						gender = :gender;';

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);
			try
			{
				$stmt->bindParam(':login', $data->login);
				$stmt->bindParam(':firstname', $data->firstname);
				$stmt->bindParam(':lastname', $data->lastname);
				$stmt->bindParam(':password', $data->password);
				$stmt->bindParam(':email', $data->email);
				$stmt->bindParam(':city', $data->city);
				$stmt->bindParam(':country', $data->country);
				$stmt->bindParam(':bio', $data->bio);
				$stmt->bindParam(':picture', $data->picture);
				$stmt->bindParam(':phonenumber', $data->phonenumber);
				$stmt->bindParam(':signupdate', $data->signupdate);
				$stmt->bindParam(':gender', $data->gender);
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
							__FILE__, __LINE__);
				return (-1);
			}
			if (!$stmt->execute())
			{
				internal_error("stmt->execute : ", __FILE__, __LINE__);
				return (-1);
			}
			http_error(201);
		}

		public function		Patch($kwargs)
		{
			if (!$kwargs
					|| !is_array($kwargs))
			{
				internal_error('kwargs not array or set to null',
								__FILE__, __LINE__);
				return (-1);
			}
			if (!isset($kwargs['id']))
			{
				internal_error("Wrong id", __FILE__, __LINE__);
				http_error(400);
				return (-1);
			}

			$id = $kwargs['id'];
			$db = $kwargs['db'];

			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}

			if (!$GLOBALS['ac_script'])
			{
				$data = json_decode(file_get_contents("php://input"));
				if (!$data)
				{
					internal_error("data set to null", __FILE__, __LINE__);
					http_error(204); //No Content
					return (-1);
				}
			}
			else
			{
				$data = json_decode('{
										"login" : "user1",
										"firstname" : "Marcel",
										"lastname" : "<h></h>",
										"password" : "password"
									}');
			}
			$data = UserPostUtilities::SanitizeData($data);

			$query = "UPDATE " . $this->table
					. " SET "
					.	((!property_exists($data, "login")) ? "" : "login = :login,")
					.	((!property_exists($data, "firstname")) ? "" : "firstname = :firstname,")
					.	((!property_exists($data, "lastname")) ? "" : "lastname = :lastname,")
					.	((!property_exists($data, "password")) ? "" : "password = :password,")
					.	((!property_exists($data, "email")) ? "" : "email = :email,")
					.	((!property_exists($data, "city")) ? "" : "city = :city,")
					.	((!property_exists($data, "country")) ? "" : "country = :country,")
					.	((!property_exists($data, "bio")) ? "" : "bio = :bio,")
					.	((!property_exists($data, "picture")) ? "" : "picture = :picture,")
					.	((!property_exists($data, "phonenumber"))
							? "" : "phonenumber = :phonenumber,")
					.	((!property_exists($data, "signupdate")) ? "" : "signup_date = :signupdate,")
					.	((!property_exists($data, "gender")) ? "" : "gender = :gender,");

			//Putain c'est degueux
			$len = strlen($query);
			$query[$len - 1] = " ";
			$query .= " WHERE id=:id";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);
			try
			{
				(!property_exists($data, "login")) ? : $stmt->bindParam(":login", $data->login);
				(!property_exists($data, "firstname")) ? : $stmt->bindParam(":firstname", $data->firstname);
				(!property_exists($data, "lastname")) ? : $stmt->bindParam(":lastname", $data->lastname);
				(!property_exists($data, "password")) ? : $stmt->bindParam(":password", $data->password);
				(!property_exists($data, "email")) ? : $stmt->bindParam(":email", $data->email);
				(!property_exists($data, "city")) ? : $stmt->bindParam(":city", $data->city);
				(!property_exists($data, "country")) ? : $stmt->bindParam(":country", $data->country);
				(!property_exists($data, "bio")) ? : $stmt->bindParam(":bio", $data->bio);
				(!property_exists($data, "picture")) ? : $stmt->bindParam(":picture", $data->picture);
				(!property_exists($data, "phonenumber")) ? : $stmt->bindParam(":phonenumber", $data->phonenumber);
				(!property_exists($data, "signupdate")) ? : $stmt->bindParam(":signupdate", $data->signupdate);
				(!property_exists($data, "gender")) ? : $stmt->bindParam(":gender", $data->gender);
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);

				if (!$stmt->execute())
				{
					internal_error("stmt->execute : ", __FILE__, __LINE__);
					return (-1);
				}
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
							__FILE__, __LINE__);
				return (-1);
			}
			http_error(200);
		}

		public function		Delete($db)
		{
			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
		}
	}
?>
