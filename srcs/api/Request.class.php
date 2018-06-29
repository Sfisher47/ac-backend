<?php

/* ************************************************************************** */
/*                                                                            */
/*  Request.class.php                                                         */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jun 29 11:07:56 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

	class		Request
	{
		public static		$verbose = false;

		public	$id;
		public	$apiVersion;
		public	$privateKey;
		public	$method;
		public	$endPoint;

		//constructor
		public function		__construct($uri, $method)
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}

			if (!is_string($uri))
			{
				bm_error('uri', __FILE__, __LINE__);
				return null;
			}
			$this->ExtractUrlData($uri);
			$this->method = $method;
		}

		//destructor
		public function		__destruct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " desctructor called !" . PHP_EOL;
			}
		}

		public function		ExtractUrlData($uri)
		{
			$data_arr = null;

			if (!is_string($uri))
			{
				bm_error('uri', __FILE__, __LINE__);
				return (0);
			}
			$data_arr = explode('/', $uri);
			$data_arr = array_filter($data_arr);
			$data_arr = array_values($data_arr);

 			$this->apiVersion = (isset($data_arr[0])) ? $data_arr[0] : null;
 			$this->privateKey = (isset($data_arr[1])) ? $data_arr[1] : null;
 			$this->endPoint = (isset($data_arr[2])) ? $data_arr[2] : null;
 			$this->id = (isset($data_arr[3])) ? $data_arr[3] : null;
		}

		public function		__toString()
		{
			return (__CLASS__ ." : \n{"
				. "\n\tmethod = [$this->method], "
				. "\n\tapiVersion = [$this->apiVersion], "
				. "\n\tprivateKey = [$this->privateKey], "
				. "\n\tendPoint = [$this->endPoint], "
				. "\n\tid = [$this->id]"
				."\n}\n"
			);
		}
	};

?>
