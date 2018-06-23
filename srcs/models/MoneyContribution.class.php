<?php

/* ************************************************************************** */
/*                                                                            */
/*  MoneyContribution.class.php                                               */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 18:26:06 2018                        by elhmn        */
/*   Updated: Sat Jun 23 18:29:11 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	MoneyContributions
	{
		private	$_id;
		private	$_userId;
		private	$_actionId;
		private	$_extraId;
		private	$_moneyNeedId;
		private	$_amount;

		public static	$_verbose = false;

// Constructor
		function	__construct()
		{
			if (MoneyContribution::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (MoneyContribution::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

	};
?>
