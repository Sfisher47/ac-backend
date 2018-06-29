<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jun 29 15:39:02 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

// header('Access-Control-Allow-Origin : *');
// header('Content-Type : application/json');
// header('Access-Control-Allow-Methods : POST');
// header('Access-Control-Allow-Headers : Access-Control-Allow-Header,
// 		Content-Type, Access-Control-Allow-Methods, Authorization,
// 		X-Requested-With');

?>

<?php
	class		UserRequest implements IRequestHandler
	{
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
		public function		Get()
		{
			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Post()
		{
			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Put()
		{
			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Update()
		{
			echo __FUNCTION__ . PHP_EOL;
		}

		public function		Delete()
		{
			echo __FUNCTION__ . PHP_EOL;
		}
	}
?>
