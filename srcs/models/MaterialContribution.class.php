<?php

/* ************************************************************************** */
/*                                                                            */
/*  MaterialContribution.class.php                                            */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 18:28:05 2018                        by elhmn        */
/*   Updated: Sat Jun 23 18:45:45 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	MaterialContribution
	{
		private	$_id;
		private	$_userId;
		private	$_actionId;
		private	$_extraId;
		private	$_materialNeedId;

		public static	$_verbose = false;

// Constructor
		function	__construct()
		{
			if (MaterialContribution::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (MaterialContribution::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

	};
?>
