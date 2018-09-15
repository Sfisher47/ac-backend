<?php

/* ************************************************************************** */
/*                                                                            */
/*  Database.class.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jan 01 01:00:00 1970                        by elhmn        */
/*   Updated: Sat Sep 15 18:53:41 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

	class	Database
	{
		public static		$verbose = false;

		private	$conn = null;

		//constructors
		public function		__constructor()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
		}

		//destructor
		public function		__destructor()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " destructor called !" . PHP_EOL;
			}
		}

		//connect to the database
		public function		Connect()
		{
			$dsn = 'mysql:host=' . Config::GetInstance()->apiHost
				. ';dbname=' . Config::GetInstance()->apiDBName;
			try
			{
				$this->conn = new PDO($dsn,
								Config::GetInstance()->dbUserName,
								Config::GetInstance()->dbPassword);
				if (!$this->conn)
				{
					internal_error("this->conn set to null", __FILE__, __LINE__);
					return (null);
				}
				$this->conn->setAttribute(PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				internal_error("Connection : {$e->getMessage()}", __FILE__, __LINE__);
				return (null);
			}
			return ($this->conn);
		}

		public function		Close()
		{
			if ($this->conn)
			{
				$this->conn->close();
				$this->conn = null;
			}
		}

	}
?>
