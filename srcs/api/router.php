<?php

/* ************************************************************************** */
/*                                                                            */
/*  router.php                                                                */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:18:29 2018                        by elhmn        */
/*   Updated: Sat Jul 07 10:08:32 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

//plateform toggler
$ac_script = isset($_SERVER['AC_SCRIPT']);

//Check if the uri was properly formatted
function		IsHandledUri($uri)
{
	if (!$uri)
	{
		internal_error("uri set to null", __FILE__, __LINE__);
		return (false);
	}

	if (empty($uri->apiVersion)
		|| array_search($uri->apiVersion,
				Config::$apiVersions) === FALSE)
	{
		internal_error("wrong apiVersion : $uri->apiVersion", __FILE__, __LINE__);
		http_error(400, 'wrong api version');
		return false;
	}

	if (empty($uri->apiKey))
	{
		internal_error("require an api key ", __FILE__, __LINE__);
		http_error(400, 'require an api key');
		return false;
	}

	if (empty($uri->endPoint)
		|| array_search($uri->endPoint,
				Config::$endPoints) === FALSE)
	{
		internal_error("wrong endPoint : $uri->endPoint", __FILE__, __LINE__);
		http_error(400, 'wrong endPoint');
		return false;
	}
	if (empty($uri->method)
		|| array_search($uri->method,
				Config::$methods) === FALSE)
	{
		internal_error("Unhandled method : $uri->method", __FILE__, __LINE__);
		http_error(405);
		return false;
	}
	return true;
}

function		IsAuthorized($uri)
{
	if (!$uri)
	{
		internal_error("uri set to null", __FILE__, __LINE__);
		return (false);
	}

	//for the moment the only authorization string handled
	//is hardcoded
	//Later we intend to load apikey from the DB
	if ($uri->apiKey !== $_SERVER['AC_ADMIN'])
	{
		internal_error("wrong key : unauthorized : $uri->apiKey", __FILE__, __LINE__);
		return (false);
	}
	return (true);
}

function CreateUserRequest() { return (new UserRequest()); };

function		HandleRequest($uri, $db)
{

	$create = [
		'users' => 'CreateUserRequest',
	];

	$methods = [
		'post' => 'Post',
	];

	if (!$GLOBALS['ac_script'])
	{
		if (!$uri)
		{
			internal_error("uri set to null", __FILE__, __LINE__);
			return (false);
		}
	}

	if (!$db)
	{
		internal_error("db set to null", __FILE__, __LINE__);
		return (-1);
	}

// 	UserRequest::$verbose = true;

// 	print_r($create);

// 	echo "uri : $uri->endPoint". PHP_EOL; // Debug
// 	echo "echo : ${create[$uri->endPoint]}". PHP_EOL; // Debug

	$elem = call_user_func("${create[$uri->endPoint]}", $db);
	if (!$elem)
	{
		internal_error("", __FILE__, __LINE__);
		return (-1);
	}

// 	echo "methods[$uri->method] = ${methods[$uri->method]}"; // Debug

	$elem->{$methods[$uri->method]}($db);

// 	echo __FUNCTION__. PHP_EOL; // Debug
}

function		Run()
{
// 	print_r($_SERVER); // Debug

	if (!$GLOBALS['ac_script'])
	{
		//Check if running plateform
		if (!isset($_SERVER['REQUEST_URI'])
				|| !isset($_SERVER['REQUEST_METHOD']))
		{
			internal_error('$_SERVER : missing fields', __FILE__, __LINE__);
			return (-1);
		}

		//Create a new uri by saving relevant uri data
		$uri = new Uri(strtolower($_SERVER['REQUEST_URI']),
						strtolower($_SERVER['REQUEST_METHOD']));

		//Check if the uri was properly formatted
		if (!IsHandledUri($uri))
		{
			internal_error('Bad uri', __FILE__, __LINE__);
			return (-1);
		}

		//Check authorization level
		if (!IsAuthorized($uri))
		{
			internal_error('Bad uri : unauthorized', __FILE__, __LINE__);
			http_error(403);
			return (0);
		}
	}
	else
	{
		$uri = new Uri("v1/admin/users/", "post");
	}

	//Create Database
	$db = new Database();
	if (!$db)
	{
		internal_error('DataBase set to null', __FILE__, __LINE__);
		return (-1);
	}

	HandleRequest($uri, $db);
}

Run();
// 	If the method is handled then call the right function method accoring
// 	to the url parameter
?>
