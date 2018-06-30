<?php

/* ************************************************************************** */
/*                                                                            */
/*  User.class.php                                                            */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 10:47:03 2018                        by elhmn        */
/*   Updated: Sat Jun 30 14:03:05 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	class User
	{
		public	$id;
		public	$firstName;
		public	$lastName;
		public	$login;
		public	$email;
		public	$password;
		public	$gender;
		public	$city;
		public	$country;
		public	$phoneNumber;
		public	$signUpDate;

		public static $verbose = false;

// Constructor
		function	__construct()
		{
			if (User::$verbose)
			{
				echo __CLASS__." constructor called" . PHP_EOL;
			}
		}

// Destructor
		function	__destruct()
		{
			if (User::$verbose)
			{
				echo __CLASS__." destructor called" . PHP_EOL;
			}
		}
	};
?>
