<?php

/* ************************************************************************** */
/*                                                                            */
/*  Database.class.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jan 01 01:00:00 1970                        by elhmn        */
/*   Updated: Thu Jun 28 12:35:06 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	Database
	{
		private	$host = 'localhost';
		private	$username = 'root';
		private	$password = '';
		private	$db_name = 'actions_citoyennes';
		private	$conn = null;

		//constructors
		public function		__constructor()
		{

		}

		//destructor
		public function		__destructor()
		{

		}

		//connect to the database
		public function		Connect()
		{
			try
			{
				this->$conn = new PDO("mysql:host = " . this->host . ";dbname=" . this->db_name, this->username, this->password);
				this->$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				echo "Connection failed : " . $e->getMessage();
			}
			return this->$conn;
		}

		//close data base connection
		public function Close()
		{
			this->$conn->close();
		}

	}
?>
