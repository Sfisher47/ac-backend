<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Jul 01 12:37:13 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

// header('Access-Control-Allow-Origin : *');
// header('Content-Type : application/json');
// header('Access-Control-Allow-Methods : POST');
// header('Access-Control-Allow-Headers : Access-Control-Allow-Header,
// 		Content-Type, Access-Control-Allow-Methods, Authorization,
// 		X-Requested-With');

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
		public function		Get($db)
		{
			if (!$db)
			{
				bm_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Post($db)
		{
			if (!$db)
			{
				bm_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}

			if (!$GLOBALS['ac_script'])
			{
				$data = json_decode(file_get_contents("php://input"));
				if (!$data)
				{
					bm_error("data set to null", __FILE__, __LINE__);
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
			print_r($data); // Debug
			if (!UserPostUtilities::CanBePosted($data, $db, $this->table))
				return (-1);

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
				bm_error("stmt->bindParam : " . $e->getMessage(),
							__FILE__, __LINE__);
				return (-1);
			}
			if (!$stmt->execute())
			{
				bm_error("stmt->execute : ", __FILE__, __LINE__);
				return (-1);
			}
		}

		public function		Put($db)
		{
			if (!$db)
			{
				bm_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
// 			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Update($db)
		{
			if (!$db)
			{
				bm_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
// 			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Delete($db)
		{
			if (!$db)
			{
				bm_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
// 			echo __FUNCTION__ . PHP_EOL;
		}
	}
?>
