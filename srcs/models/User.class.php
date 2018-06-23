<?php

/* ************************************************************************** */
/*                                                                            */
/*  User.class.php                                                            */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Sat Jun 23 10:47:03 2018                        by elhmn        */
/*   Updated: Sat Jun 23 18:35:02 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	class User
	{
		private	$_id;
		private	$_firstName;
		private	$_lastName;
		private	$_login;
		private	$_email;
		private	$_password;
		private	$_gender;
		private	$_city;
		private	$_country;
		private	$_phoneNumber;
		private	$_signUpDate;

		public static _verbose = false;

// Constructor
		function	__construct()
		{
			if (User::$_verbose)
			{
				echo __CLASS__." constructor called";
			}
		}

// Destructor
		function	__destruct()
		{
			if (User::$_verbose)
			{
				echo __CLASS__." destructor called";
			}
		}

// Getters
		function	getId(){return ($this->_id);}
		function	getFirstName(){return ($this->_firstName);}
		function	getLastName(){return ($this->_lastName);}
		function	getLogin(){return ($this->_login);}
		function	getGender(){return (this->_gender);}
		function	getEmail(){return ($this->_email);}
		function	getCity(){return ($this->_city);}
		function	getCountry(){return ($this->_country);}
		function	getPhoneNumber(){return ($this->_phoneNumber);}
		function	getSignUpDate(){return ($this->_getSignUpDate);}

// Setters
		function	setFirstName($val){$this->_firstName = $val;}
		function	setLastName($val){$this->_lastName = $val;}
		function	setEmail($val){$this->_email = $val;}
		function	setId($val){$this->_id = $val;}
		function	setCity($val){$this->_city = $val;}
		function	setCountry($val){$this->_country = $val;}
		function	setGender($val){$this->_gender = $val;}
		function	setPhoneNumber($val){$this->_phoneNumber = $val;}
		function	setSignUpDate($val){$this->_signUpDate = $val;}
	};
?>
