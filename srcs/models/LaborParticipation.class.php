<?php
	class	LaborParticipation
	{
		private $_id;
		private $_userID;
		private $_actionId;
		private	$_extraID;
		private $_laborNeedId;

		public static	$_verbose = false;
		
// Constructor
		function	__construct()
		{
			if (LaborParticipation::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (LaborParticipation::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

	};
?>
