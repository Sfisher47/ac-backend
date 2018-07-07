<?php

/* ************************************************************************** */
/*                                                                            */
/*  Database.class.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jan 01 01:00:00 1970                        by elhmn        */
/*   Updated: Sat Jun 30 16:50:33 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	class	Database
	{
		public static		$verbose = false;

		private	$host = 'localhost';
		private	$username = 'bmbarga';

		//the password must be hidden later on
		//or loaded from a file
		private	$password = 'test';
		private	$db_name = 'actions_citoyennes';
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
// 			for Unix based system running on socket mode
			$dsn = 'mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock'.
				';dbname=' . $this->db_name;
// 			else
// 				$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
			try
			{
				$this->conn = new PDO($dsn, $this->username, $this->password);
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
				internal_error("Connection : $e->getMessage()", __FILE__, __LINE__);
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
