<?php

/* ************************************************************************** */
/*                                                                            */
/*  LaborContribution.class.php                                               */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 18:30:11 2018                        by elhmn        */
/*   Updated: Sat Jun 23 18:31:02 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	LaborContribution
	{
		private	$_id;
		private	$_userID;
		private	$_actionId;
		private	$_extraID;
		private	$_laborNeedId;

		public static	$_verbose = false;

// Constructor
		function	__construct()
		{
			if (LaborContribution::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (LaborContribution::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

	};
?>
