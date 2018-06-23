<?php

/* ************************************************************************** */
/*                                                                            */
/*  MoneyNeed.class.php                                                       */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 10:47:03 2018                        by elhmn        */
/*   Updated: Sat Jun 23 18:27:26 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	MoneyNeed
	{
		private	$_id;
		private	$_title;
		private $_description;
		private	$_required;
		private	$_collected;
		private $_actionId;
		private $_extraId;

		public static $_verbose = false;

// Constructor
		function	__construct()
		{
			if (MoneyNeed::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (MoneyNeed::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

// Getters

// Setters

	};
?>
