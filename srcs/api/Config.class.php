<?php

/* ************************************************************************** */
/*                                                                            */
/*  Config.class.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Tue Aug 28 20:31:51 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	class		Config
	{
		public static		$verbose = false;

		public static		$apiVersions = [
			'v1'
		];

		public static		$methods = [
			'get',
			'post',
			'patch',
// 			'delete'
		];

		public static		$endPoints = [
			'users',
			'actions',
			'extras',
			'laborcontributions',
			'materialcontributions',
			'moneycontributions',
			'laborneeds',
			'materialneeds',
			'moneyneeds',
		];

		private static		$instance = null;

		public static		$error_log_file = "./logs/error.log";

		//constructor
		private function		__construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
		}

		public static function			getInstance()
		{
			if (Config::$instance === null)
			{
				if (!(Config::$instance = new Config()))
				{
					internal_error("Config::instance construction failed !",
						__FILE__, __LINE__);
					return (null);
				}
			}
			return (Config::$instance);
		}

		//destructor
		private function		__destruct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " desctructor called !" . PHP_EOL;
			}
		}

		public static function		LogClass()
		{
			return (__CLASS__ . " : \n{"
				. "\n\tapiVersions = [$this->apiVersions], "
				."\n}\n"
			);
		}
	};

?>
