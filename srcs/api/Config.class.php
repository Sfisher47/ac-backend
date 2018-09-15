<?php

/* ************************************************************************** */
/*                                                                            */
/*  Config.class.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Sep 15 19:06:10 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

	class		Config
	{
		public static		$verbose = false;

		public 		$authHost = 'localhost'; // Default
		public 		$apiHost = 'localhost'; // Default
		public 		$dbUserName = 'root'; // Default
		public 		$dbPassword = 'test'; // Default
		public 		$apiDBName = 'actions_citoyennes'; // Default
		public 		$authDBName = 'ac_authentication'; // Default
		public 		$testApiKey = 'test'; // Default

		public 		$apiVersions = [
			'v1'
		];

		public 		$methods = [
			'get',
			'post',
			'patch',
// 			'delete'
		];

		public 		$endPoints = [
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

		private static 	$instance = null;

		public 			$errorLogFileName = "./logs/error.log";
		public 			$configFileName = "./config.json";

		private function		initConfigData()
		{
			$data = json_decode(file_get_contents($this->configFileName));
			$this->authHost = $data->authHost;
			$this->apiHost = $data->apiHost;
			$this->dbUserName = $data->dbUserName;
			$this->dbPassword = $data->dbPassword;
			$this->apiDBName = $data->apiDBName;
			$this->authDBName = $data->authDBName;
			$this->testApiKey = $data->testApiKey;
		}

		//constructor
		private function		__construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
			$this->initConfigData();
		}

		public static function			GetInstance()
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
		public function		__destruct()
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
