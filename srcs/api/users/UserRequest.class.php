<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jul 07 12:08:18 2018                        by bmbarga      */
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
		public function		Get($kwarg)
		{
			if (!$kwarg
					|| !is_array($kwarg))
			{
				internal_error('kwarg not array or set to null',
								__FILE__, __LINE__);
				return (-1);
			}
			$id = $kwarg['id'];
			$db = $kwarg['db'];

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

		public function		Post($kwarg)
		{
			if (!$kwarg
					|| !is_array($kwarg))
			{
				internal_error('kwarg not array or set to null',
								__FILE__, __LINE__);
				return (-1);
			}

			$db = $kwarg['db'];

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

		public function		Put($db)
		{
			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
		}

		public function		Update($db)
		{
			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
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
