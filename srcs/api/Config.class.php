<?php

/* ************************************************************************** */
/*                                                                            */
/*  Config.class.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Mon Nov 26 13:21:41 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	class		Config
	{
		public static		$verbose = false;

		public 		$authHost = 'localhost'; // Default
		public 		$apiHost = 'localhost'; // Default
		public 		$apiDBUserName = 'root'; // Default
		public 		$apiDBPassword = 'test'; // Default
		public 		$authDBUserName = 'root'; // Default
		public 		$authDBPassword = 'test'; // Default
		public 		$apiDBName = 'actions_citoyennes'; // Default
		public 		$authDBName = 'ac_authentication'; // Default
		public 		$testApiKey = 'test'; // Default

		public 		$apiVersions = [
			'v1'
		];

		public 		$apiTypes = [
			'public',
			'private'
		];

		public 		$methods = [
			'get',
			'post',
			'patch',
 			'delete'
		];

		public 		$endPoints = [
			'users',
			'actions',
			'featuredactions',
			'completedactions',
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
			$this->apiDBUserName = $data->apiDBUserName;
			$this->apiDBPassword = $data->apiDBPassword;
			$this->authDBUserName = $data->authDBUserName;
			$this->authDBPassword = $data->authDBPassword;
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
