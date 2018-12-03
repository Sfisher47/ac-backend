<?php

/* ************************************************************************** */
/*                                                                            */
/*  FeaturedActionsPubRequest.class.php                                       */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Thu Nov 29 16:41:30 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */
	require_once __API_DIR__ . '/IRequestHandler.class.php';

	class		FeaturedActionsPubRequest implements IRequestHandler
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
			$db = $kwargs["db"];

			//This is a basic request and it will be enhanced later
			// Get all actions
			$baseQuery = "SELECT mix.*, usr.lastname, usr.firstname FROM (SELECT Actions.*, Extras.id as extra_id FROM Actions LEFT JOIN Extras ON Extras.action_id = Actions.id) mix LEFT JOIN Users usr ON usr.id=mix.user_id ";
			$query = $baseQuery . " LIMIT 6";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!$ret)
			{
				http_error(204, '{"response" : "nothing found"}');
				return (-1);
			}

			echo json_encode($ret);
		}

		public function		Post($kwargs)
		{
			http_error(400);
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
