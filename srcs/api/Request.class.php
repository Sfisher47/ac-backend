<?php

/* ************************************************************************** */
/*                                                                            */
/*  Request.class.php                                                         */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Thu Jun 28 18:20:14 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

	class		Request
	{
		public static		$_verbose = false;

		public	$id;
		public	$method;
		public	$endPoint;

		//constructor
		public function		__construct($uri)
		{
			if ($Request::_verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}

			if (!is_string($uri))
			{
				error_log('uri', __FILE__, __LINE__);
				return null;
			}
		}

		//destructor
		public function		__destruct()
		{
			if ($Request::_verbose)
			{
				echo __CLASS__. " desctructor called !" . PHP_EOL;
			}
		}

	};

?>
