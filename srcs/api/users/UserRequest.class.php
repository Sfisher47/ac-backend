<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jun 30 16:50:48 2018                        by bmbarga      */
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
			print_r($data); // Debug

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
				$stmt->bindParam(':login',
					htmlspecialchars(strip_tags(($data->login))));
				$stmt->bindParam(':firstname',
					htmlspecialchars(strip_tags(($data->firstname))));
				$stmt->bindParam(':lastname',
					htmlspecialchars(strip_tags(($data->lastname))));
				$stmt->bindParam(':password',
					htmlspecialchars(strip_tags(($data->password))));
				$stmt->bindParam(':email',
					htmlspecialchars(strip_tags(($data->email))));
				$stmt->bindParam(':city',
					htmlspecialchars(strip_tags(($data->city))));
				$stmt->bindParam(':country',
					htmlspecialchars(strip_tags(($data->country))));
				$stmt->bindParam(':bio',
					htmlspecialchars(strip_tags(($data->bio))));
				$stmt->bindParam(':picture',
					htmlspecialchars(strip_tags(($data->picture))));
				$stmt->bindParam(':phonenumber',
					htmlspecialchars(strip_tags(($data->phonenumber))));
				$stmt->bindParam(':signupdate',
					htmlspecialchars(strip_tags(($data->signupdate))));
				$stmt->bindParam(':gender',
					htmlspecialchars(strip_tags(($data->gender))));
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
