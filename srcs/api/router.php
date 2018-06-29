<?php

/* ************************************************************************** */
/*                                                                            */
/*  router.php                                                                */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:18:29 2018                        by elhmn        */
/*   Updated: Fri Jun 29 17:47:58 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

//plateform toggler
$ac_script = isset($_SERVER['AC_SCRIPT']);

//Check if the uri was properly formatted
function		IsHandledUri($uri)
{
	if (!$uri)
	{
		bm_error("uri set to null", __FILE__, __LINE__);
		return (false);
	}

	if (empty($uri->apiVersion)
		|| array_search($uri->apiVersion,
				Config::$apiVersions) === FALSE)
	{
		bm_error("wrong apiVersion : $uri->apiVersion", __FILE__, __LINE__);
		return false;
	}

	if (empty($uri->apiKey))
	{
		bm_error("require a api key ", __FILE__, __LINE__);
		return false;
	}

	if (empty($uri->endPoint)
		|| array_search($uri->endPoint,
				Config::$endPoints) === FALSE)
	{
		bm_error("wrong endPoint : $uri->endPoint", __FILE__, __LINE__);
		return false;
	}
	if (empty($uri->method)
		|| array_search($uri->method,
				Config::$methods) === FALSE)
	{
		bm_error("Unhandled method : $uri->method", __FILE__, __LINE__);
		return false;
	}
	return true;
}

function		IsAuthorized($uri)
{
	if (!$uri)
	{
		bm_error("uri set to null", __FILE__, __LINE__);
		return (false);
	}

	//for the moment the only authorization string handled
	//is hardcoded
	//Later we intend to load apikey from the DB
	if ($uri->apiKey !== $_SERVER['AC_ADMIN'])
	{
		bm_error("wrong key : unauthorized : $uri->apiKey", __FILE__, __LINE__);
		return (false);
	}
	return (true);
}

function CreateUserRequest() { return (new UserRequest()); };

function		HandleRequest($uri)
{

	$create = [
		'users' => 'CreateUserRequest',
	];

	if (!$GLOBALS['ac_script'])
	{
		if (!$uri)
		{
			bm_error("uri set to null", __FILE__, __LINE__);
			return (false);
		}
	}

	UserRequest::$verbose = true;

	print_r($create);

	echo "uri : $uri->endPoint". PHP_EOL; // Debug
// 	echo "echo : ${create[$uri->endPoint]}". PHP_EOL; // Debug

	$elem = call_user_func($create[$uri->endPoint]);
	if (!$elem)
	{
		bm_error("", __FILE__, __LINE__);
		return (-1);
	}

	$elem->Post();
	$elem->Put();
	$elem->Update();
	$elem->Get();
	$elem->Delete();

	echo __FUNCTION__. PHP_EOL;
}

function		Run()
{
	print_r($_SERVER); // Debug

	if (!$GLOBALS['ac_script'])
	{
		//Check if running plateform
		if (!isset($_SERVER['REQUEST_URI'])
				|| !isset($_SERVER['REQUEST_METHOD']))
		{
			bm_error('$_SERVER : missing fields', __FILE__, __LINE__);
			return (-1);
		}

		//Create a new uri by saving relevant uri data
		$uri = new Uri(strtolower($_SERVER['REQUEST_URI']),
						strtolower($_SERVER['REQUEST_METHOD']));

		//Check if the uri was properly formatted
		if (!IsHandledUri($uri))
		{
			bm_error('Bad uri', __FILE__, __LINE__);
			return (-1);
		}

		//Check authorization level
		if (!IsAuthorized($uri))
		{
			bm_error('Bad uri : unauthorized', __FILE__, __LINE__);
			return (0);
		}
	}

	//Create Database
	Database::$verbose = true;
	$db = new Database();
	if ($db === null)
	{
		bm_error('DataBase set to null', __FILE__, __LINE__);
		return (-1);
	}

	HandleRequest($uri);
}

run();
// 	If the method is handled then call the right function method accoring
// 	to the url parameter
?>
