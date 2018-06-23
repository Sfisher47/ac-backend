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
