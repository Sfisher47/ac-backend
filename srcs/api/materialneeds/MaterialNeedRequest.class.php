<?php

/* ************************************************************************** */
/*                                                                            */
/*  MaterialNeedRequest.class.php                                             */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Wed Nov 28 12:43:52 2018                        by elhmn        */
/*   Updated: Wed Nov 28 15:39:40 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */
	require_once __API_DIR__ . '/IRequestHandler.class.php';
	require_once __API_DIR__ . '/actions/ActionRequestUtilities.class.php';
	require_once __API_DIR__ . '/extras/ExtraRequestUtilities.class.php';
	require_once __API_DIR__ . '/materialneeds/MaterialNeedRequestUtilities.class.php';

	class		MaterialNeedRequest implements IRequestHandler
	{
		private			$table = "MaterialNeeds";
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
			$db = $kwargs["db"];
			$auth = $kwargs["auth"];


			if ($auth->getmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}

			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}


			// Get one or all laborneeds
			$baseQuery = "SELECT mat.*, mix.user_id FROM "
				. $this->table
				. " mat LEFT JOIN "
				. " (SELECT act.id AS action_id, act.user_id, extr.id AS extra_id "
				. " FROM Actions act LEFT JOIN Extras extr ON extr.action_id = act.id) "
				. " mix ON mix.action_id=mat.action_id  OR mix.extra_id=mat.extra_id "
				. " WHERE mix.user_id=$auth->userid ";
			$query = (!$id) ? $baseQuery
				: $baseQuery . " AND mat.id=$id ";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

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

			$db = $kwargs["db"];
			$auth = $kwargs["auth"];
			$data = $kwargs["data"];

			if ($auth->postmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}

			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}

			if (!$data && !$GLOBALS['ac_script'])
			{
				$data = json_decode(file_get_contents("php://input"));
				if (!$data)
				{
					internal_error("data set to null", __FILE__, __LINE__);
					http_error(204); //No Content
					return (-1);
				}
			}

			// Create laborneed

			MaterialNeedRequestUtilities::SanitizeData($data);

			/*
			if ( !isset($data->action_id) && !isset($data->extra_id) )
			{
				internal_error("action or extra is required", __FILE__, __LINE__);
				http_error(403);
				return (-1);
			}
			*/

			if ( isset($data->action_id) && isset($data->extra_id) )
			{
				$data->extra_id = null;
			}

			if ( !ActionRequestUtilities::IsOwn($db, $data->action_id, $auth->userid)
		  &&   !ExtraRequestUtilities::IsOwn($db, $data->extra_id, $auth->userid) )
			{
				internal_error("user isnt owner action or extra", __FILE__, __LINE__);
				http_error(403);
				return (-1);
			}

			$query = 'INSERT INTO ' . $this->table . ' SET
			required = :required,
			title = :title,
			description = :description,
			unit = :unit'
			. (isset($data->collected) ? ',collected = :collected' : '')
			. (isset($data->action_id) ? ',action_id = :actionId' : '')
			. (isset($data->extra_id) ?  ',extra_id = :extraId' : '')
			. ';';

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			try
			{
				$stmt->bindParam(':title', $data->title);
				$stmt->bindParam(':description', $data->description);
				$stmt->bindParam(':required', $data->required);
				$stmt->bindParam(':unit', $data->unit);
				isset($data->collected) ? $stmt->bindParam(':collected', $data->collected) : false;
				isset($data->action_id) ? $stmt->bindParam(':actionId', $data->action_id) : false;
				isset($data->extra_id) ? $stmt->bindParam(':extraId', $data->extra_id) : false;

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
			http_error(400);
		}

		public function		Delete($kwargs)
		{
			http_error(400);
		}
	}
?>