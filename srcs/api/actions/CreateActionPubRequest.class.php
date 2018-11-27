<?php

/* ************************************************************************** */
/*                                                                            */
/*  CreateActionPubRequest.class.php                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Tue Nov 27 22:58:52 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */
	require_once __API_DIR__ . '/IRequestHandler.class.php';

	class		CreateActionPubRequest implements IRequestHandler
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
			http_error(400);
		}

		public function		Post($kwargs)
		{
			if (!($data = json_decode(file_get_contents("php://input"))))
			{
				internal_error("data set to null", __FILE__, __LINE__);
				http_error(204);
				return (-1);
			}

			if (!property_exists($data, 'action'))
			{
				internal_error("no action field", __FILE__, __LINE__);
				http_error(400);
				return (-1);
			}

			if (!property_exists($data, 'token'))
			{
				internal_error("no token field", __FILE__, __LINE__);
				http_error(400);
				return (-1);
			}

			$kwargs = array_merge($kwargs,
						array("data" => $data->action));
			$kwargs = array_merge($kwargs,
						array("auth" => GetAuthorizations($data->token)));
			if (!($action = new ActionRequest()))
			{
				internal_error("action set to null", __FILE__, __LINE__);
				http_error(500);
				return (-1);
			}

			//Clean response
			ob_start();
			$action_id = $action->Post($kwargs);
			ob_clean();

			//Create materialneeds with action_id
			//Create laborneeds with action_id

			if (property_exists($data, 'extra'))
			{
				if (!($extra = new ExtraRequest()))
				{
					internal_error("extra set to null", __FILE__, __LINE__);
					http_error(500);
					return (-1);
				}
				$data->extra = array_merge((array)$data->extra,
							array("action_id" => $action_id));
				$kwargs = array_merge($kwargs,
							array("data" => (object)$data->extra));
				//Clean response
				ob_start();
				$extra_id = $extra->Post($kwargs);
				ob_clean();
				//Create materialneeds with extra_id
				//Create laborneeds with extra_id
			}
			if ($extra_id < 0 || $action_id < 0)
			{
				http_error(400);
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
