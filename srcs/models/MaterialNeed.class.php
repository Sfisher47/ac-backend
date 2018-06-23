<?php

/* ************************************************************************** */
/*                                                                            */
/*  MaterialNeed.class.php                                                    */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 10:47:03 2018                        by elhmn        */
/*   Updated: Sat Jun 23 12:00:13 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	MaterialNeed
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
			if (MaterialNeed::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (MaterialNeed::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

// Getters

// Setters

	};
?>
