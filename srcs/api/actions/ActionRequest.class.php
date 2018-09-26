<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Aug 05 10:19:39 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	require_once __API_DIR__ . '/IRequestHandler.class.php';
	require_once __API_DIR__ . '/actions/ActionRequestUtilities.class.php';

	class		ActionRequest implements IRequestHandler
	{
		private			$table = "Actions";
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
				internal_error("kwargs not array or set to null",
								__FILE__, __LINE__);
				return (-1);
			}
			$id = $kwargs["id"];
			$auth = $kwargs["auth"];
			
			/*
			if ($auth->getmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}
			
			if ($auth->getmethod === Auths::OWN
				&& $auth->userid !== $id)
			{
				http_error(403);
				return (-1);
			}
			*/
			
			// Get one or all actions
			$query = (!$id) ? 'SELECT * FROM ' . $this->table
						        : 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
			
			$db = new Database();
			$conn = $db->Connect();
			$stmt = $conn->prepare($query);
			
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if (!$ret)
			{
				echo '{"response" : "nothing found"}';
				return (0);
			}

			echo json_encode($ret);
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
			
			$auth = $kwargs["auth"];
			
			/*
			if ($auth->postmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}
			*/
			
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
			
			ActionRequestUtilities::SanitizeData($data);
			
			// Create action
			
			$query = 'INSERT INTO ' . $this->table . ' SET
			title = :title,
			street = :street,
			address_info = :addressInfo,
			postal_code = :codePostal,
			city = :city,
			coutry = :country,
			description = :description,
			date = :date,
			time = :time,
			duration = :duration,
			user_id = :userId;';
			
			$db = new Database();
			$conn = $db->Connect();
			$stmt = $conn->prepare($query);
			
			try
			{
				$stmt->bindParam(':title', $data->title);
				$stmt->bindParam(':street', $data->street);
				$stmt->bindParam(':addressInfo', $data->addressInfo);
				$stmt->bindParam(':codePostal', $data->codePostal);
				$stmt->bindParam(':city', $data->city);
				$stmt->bindParam(':country', $data->country);
				$stmt->bindParam(':description', $data->description);
				$stmt->bindParam(':date', $data->date);
				$stmt->bindParam(':time', $data->time);
				$stmt->bindParam(':duration', $data->duration);
				$stmt->bindParam(':userId', $data->userId);
				
				$stmt->execute();
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				return (-1);
			}
			
			try
			{
				$stmt->execute();
			}
			catch (Exception $e)
			{
				internal_error("stmt->execute : ". $e->getMessage(), __FILE__, __LINE__);
				http_error(400, $e->getMessage());
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
			$auth = $kwargs["auth"];
			
			/*
			if ($auth->patchmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}
			
			if ($auth->patchmethod === Auths::OWN
				&& $auth->userid !== $id)
			{
				http_error(403);
				return (-1);
			}
			*/

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
			
			// Put update action here
			
			http_error(200);
		}

		public function		Delete($kwargs)
		{
			if (!$kwargs)
			{
				internal_error("kwargs not array or set to null", __FILE__, __LINE__);
				return (-1);
			}
			if (!isset($kwargs['id']))
			{
				internal_error("Wrong id", __FILE__, __LINE__);
				http_error(400);
				return (-1);
			}

			$id = $kwargs['id'];
			$auth = $kwargs["auth"];
			
			/*
			if ($auth->delmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}
			
			if ($auth->delmethod === Auths::OWN
				&& $auth->userid !== $id)
			{
				http_error(403);
				return (-1);
			}
			*/
			
			// Put delete action here
			
			http_error(200);
			
		}
	}
?>
