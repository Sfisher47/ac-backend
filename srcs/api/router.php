<?php

/* ************************************************************************** */
/*                                                                            */
/*  router.php                                                                */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:18:29 2018                        by elhmn        */
/*   Updated: Fri Jun 29 11:37:50 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

//Check if the request was properly formatted
function		IsHandledRequest($request)
{
	if (!$request)
	{
		bm_error("request set to null", __FILE__, __LINE__);
		return (false);
	}

	if (empty($request->apiVersion)
		|| array_search($request->apiVersion,
				Config::$apiVersions) === FALSE)
	{
		bm_error("wrong apiVersion : $request->apiVersion", __FILE__, __LINE__);
		return false;
	}

	if (empty($request->privateKey))
	{
		bm_error("require a private key ", __FILE__, __LINE__);
		return false;
	}

	if (empty($request->endPoint)
		|| array_search($request->endPoint,
				Config::$endPoints) === FALSE)
	{
		bm_error("wrong endPoint : $request->endPoint", __FILE__, __LINE__);
		return false;
	}
	if (empty($request->method)
		|| array_search($request->method,
				Config::$methods) === FALSE)
	{
		bm_error("Unhandled method : $request->method", __FILE__, __LINE__);
		return false;
	}
	return true;
}

function		main()
{
// 		$routes = [
// 			'users' => './users/.php',
// 			'actions' => './actions/',
// 			'extras' => './extras/',
// 			'laborcontributions' => './laborContributions/',
// 			'materialcontributions' => './materialContributions/',
// 			'moneycontributions' => './moneyContributions/',
// 			'laborneeds' => './laborNeeds/',
// 			'materialneeds' => './materialNeeds/',
// 			'moneyneeds' => './moneyNeeds/',
// 		];
		print_r($_SERVER); // Debug

	if (!isset($_SERVER['REQUEST_URI'])
			|| !isset($_SERVER['REQUEST_METHOD']))
	{
		bm_error('$_SERVER : missing fields', __FILE__, __LINE__);
		return (0);
	}

	//Create a new request by saving relevant request data
	$request = new Request(strtolower($_SERVER['REQUEST_URI']),
					strtolower($_SERVER['REQUEST_METHOD']));

	//Check if the request was properly formatted
	if (!IsHandledRequest($request))
	{
		bm_error('Bad request', __FILE__, __LINE__);
		return (0);
	}

}

main();
// 	Check url
// 	Check authorization
// 	Check methods (POST | GET | PUT | PATCH | DELETE).
//
// 	If the method is handled then call the right function method accoring
// 	to the url parameter

?>
