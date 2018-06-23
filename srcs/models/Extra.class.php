<?php

/* ************************************************************************** */
/*                                                                            */
/*  Extra.class.php                                                           */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 11:34:06 2018                        by elhmn        */
/*   Updated: Sat Jun 23 11:59:40 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	Extra
	{
		private	$_id;
		private	$_title;
		private	$_description;
		private	$_city;
		private	$_country;
		private	$_date;
		private $_time;
		private	$_duration;
		private	$_userId;
		private	$_creationDate;

		public static $_verbose = false;

// Constructor
		function	__construct()
		{
			if (Extra::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (Extra::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

// Getters

// Setters

	};
?>
