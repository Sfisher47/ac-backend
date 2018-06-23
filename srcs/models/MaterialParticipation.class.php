<?php

/* ************************************************************************** */
/*                                                                            */
/*  MaterialParticipation.class.php                                           */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 10:47:03 2018                        by elhmn        */
/*   Updated: Sat Jun 23 12:00:36 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class	MaterialParticipation
	{
		private $_id;
		private $_userID;
		private $_actionId;
		private	$_extraID;
		private $_materialNeedId;

		public static	$_verbose = false;

// Constructor
		function	__construct()
		{
			if (MaterialParticipation::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (MaterialParticipation::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

	};
?>
