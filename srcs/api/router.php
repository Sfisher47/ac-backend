<?php

/* ************************************************************************** */
/*                                                                            */
/*  router.php                                                                */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:18:29 2018                        by elhmn        */
/*   Updated: Thu Jun 28 18:21:24 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

	function		main()
	{
		$routes = [
			'users' => './users/.php',
			'actions' => './actions/',
			'extras' => './extras/',
			'laborcontributions' => './laborContributions/',
			'materialcontributions' => './materialContributions/',
			'moneycontributions' => './moneyContributions/',
			'laborneeds' => './laborNeeds/',
			'materialneeds' => './materialNeeds/',
			'moneyneeds' => './moneyNeeds/',
		];

		print_r($_SERVER); // Debug
		if (!isset($_SERVER['REQUEST_URI']))
		{
			log_error('$_SERVER["REQUEST_URI"]', __FILE__, __LINE__);
			return (0);
		}
		$request = new Request($_SERVER['REQUEST_URI']);
	}

	main();
// 	Check url
// 	Check authorization
// 	Check methods (POST | GET | PUT | PATCH | DELETE).
//
// 	If the method is handled then call the right function method accoring
// 	to the url parameter

?>
