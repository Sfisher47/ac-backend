<?php

/* ************************************************************************** */
/*                                                                            */
/*  Database.class.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jan 01 01:00:00 1970                        by elhmn        */
/*   Updated: Sun Jun 24 09:23:57 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	Database
	{
		private	$host = '';
		private	$root = '';
		private	$password = '';
		private	$db_name = '';
		private	$conn;

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
				this->$conn = new PDO("mysql:host = " . this->host . "dbname=" . this->db_name, this->username, this->password);
				this->$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				echo "Connection failed : " . $e->getMessage();
			}
		}

		//close data base connection
		public function Close()
		{
			this->$conn->close();
		}

	}
?>
