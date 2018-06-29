<?php

/* ************************************************************************** */
/*                                                                            */
/*  Config.class.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jun 29 12:34:32 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

	class		Config
	{
		public static		$verbose = false;

		public static		$apiVersions = [
			'v1',
			'v2'
		];

		public static		$methods = [
			'get',
// 			'post',
// 			'put',
// 			'update',
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

		//constructor
		public function		__construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
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
