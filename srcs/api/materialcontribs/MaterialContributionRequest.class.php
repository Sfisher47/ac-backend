<?php

/* ************************************************************************** */
/*                                                                            */
/*  MaterialContributionRequest.class.php                                     */
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
	require_once __API_DIR__ . '/extras/ExtraRequestUtilities.class.php';
	require_once __API_DIR__ . '/materialcontribs/MaterialContributionRequestUtilities.class.php';

	class		MaterialContributionRequest implements IRequestHandler
	{
		private			$table = "MaterialContributions";
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
			
			// Get one or all materialcontribs
			// TO DO

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
			
			// Create materialcontrib
			// TO DO
			
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
			$db = $kwargs["db"];
			$auth = $kwargs["auth"];

			if ($auth->patchmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}
			
			if ($auth->patchmethod === Auths::OWN
				&& !MaterialContributionRequestUtilities::IsOwn($db, $id, $auth->userid))
			{
				http_error(403);
				return (-1);
			}
			
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
			
			// Put update materialcontrib here
			// TO DO
			
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
			$db = $kwargs["db"];
			$auth = $kwargs["auth"];

			if ($auth->delmethod === Auths::NONE)
			{
				http_error(403);
				return (-1);
			}
			
			if ($auth->delmethod === Auths::OWN
				&& !MaterialContributionRequestUtilities::IsOwn($db, $id, $auth->userid))
			{
				http_error(403);
				return (-1);
			}
			
			if (!$db)
			{
				internal_error("db set to null", __FILE__, __LINE__);
				return (-1);
			}
			
			// Delete materialcontrib
			// TO DO
			
			http_error(200);
			
		}
	}
?>
