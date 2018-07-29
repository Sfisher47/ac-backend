<?php

/* ************************************************************************** */
/*                                                                            */
/*  router.php                                                                */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:18:29 2018                        by elhmn        */
/*   Updated: Sun Jul 29 08:13:18 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

//plateform toggler
$ac_script = isset($_SERVER['AC_SCRIPT']);

//Check if the uri was properly formatted
function		IsHandledUri($uri)
{
	if (!$uri)
	{
		internal_error("uri set to null",
						__FILE__, __LINE__);
		return (false);
	}

	if (empty($uri->apiVersion)
		|| array_search($uri->apiVersion,
				Config::$apiVersions) === FALSE)
	{
		internal_error("wrong apiVersion : $uri->apiVersion",
						__FILE__, __LINE__);
		http_error(400, 'wrong api version');
		return false;
	}

	if (empty($uri->apiKey))
	{
		internal_error("require an api key ",
						__FILE__, __LINE__);
		http_error(400, 'require an api key');
		return false;
	}

	if (empty($uri->endPoint)
		|| array_search($uri->endPoint,
				Config::$endPoints) === FALSE)
	{
		internal_error("wrong endPoint : $uri->endPoint",
						__FILE__, __LINE__);
		http_error(400, 'wrong endPoint');
		return false;
	}
	if (empty($uri->method)
		|| array_search($uri->method,
				Config::$methods) === FALSE)
	{
		internal_error("Unhandled method : $uri->method",
						__FILE__, __LINE__);
		http_error(405);
		return (false);
	}
	return (true);
}

function		GetTokenField($conn, $tableName, $token)
{
	//Check if password already exists
	$queryToken = "SELECT token, postmethod, patchmethod, getmethod, delmethod, userid FROM $tableName WHERE token='$token'";
	try
	{
		$stmtToken = $conn->prepare($queryToken);
		$stmtToken->execute();
		$ret = $stmtToken->fetchAll(PDO::FETCH_OBJ);
		print_r($ret); // Debug
		return ($ret);
	}
	catch(Exception $e)
	{
		$stmtToken->debugDumpParams();
		internal_error("stmtToken : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (null);
	}
	return (null);
}

function		GetAuthorizations($apiKey)
{
	if (empty($apiKey))
		return (null);
	$db = new Database();
	if (!$db)
	{
		internal_error('DataBase set to null', __FILE__, __LINE__);
		return (null);
	}
	$db->db_name = "ac_authentication";
	if (!($conn = $db->Connect()))
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (null);
	}
	return (GetTokenField($conn, 'tokens', $apiKey));
}

function		IsAuthorized($uri)
{
	$authorizations = (object) [
		"postmethod" => Auths::ALL,
	];

	//This case is only used for testing purposes and must never be in producttion
	if ($uri->apiKey === $_SERVER['AC_ADMIN'])
	{
		return ($authorizations);
	}

	if ($uri->method === "post")
	{
		return ($authorizations);
	}

	if (!$uri)
	{
		internal_error("uri set to null",
						__FILE__, __LINE__);
		return (null);
	}

	if (!($authorizations = GetAuthorizations($uri->apiKey)))
	{
		internal_error("wrong key : unauthorized : $uri->apiKey",
						__FILE__, __LINE__);
		return (null);
	}
	return ($authorizations);
}

function CreateUserRequest() { return (new UserRequest()); };

function		HandleRequest($uri, $db, $authorizations)
{

	$create = [
		'users' => 'CreateUserRequest',
	];

	$methods = [
		'post' => 'Post',
		'get' => 'Get',
		'patch' => 'Patch',
	];

	if (!$GLOBALS['ac_script'])
	{
		if (!$uri)
		{
			internal_error("uri set to null",
							__FILE__, __LINE__);
			return (-1);
		}
	}

	if (!$db)
	{
		internal_error("db set to null",
						__FILE__, __LINE__);
		return (-1);
	}

	$elem = call_user_func("${create[$uri->endPoint]}", $db);
	if (!$elem)
	{
		internal_error("", __FILE__, __LINE__);
		return (-1);
	}

	$elem->{$methods[$uri->method]}(["db" => $db, "id" => $uri->id, "auth" => $authorizations]);
}

function		Run()
{
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
	}
	else
	{
		$uri = new Uri("v1/admin/users", "get");
	}

	//Check if the uri was properly formatted
	if (!IsHandledUri($uri))
	{
		internal_error('Bad uri', __FILE__, __LINE__);
		return (-1);
	}

	//Check authorization level
	if (!($authorizations = IsAuthorized($uri)))
	{
		internal_error('Bad uri : unauthorized', __FILE__, __LINE__);
		http_error(403);
		return (-1);
	}

	//Create Database
	$db = new Database();
	if (!$db)
	{
		internal_error('DataBase set to null', __FILE__, __LINE__);
		return (-1);
	}

	HandleRequest($uri, $db, $authorizations);
}

Run();

?>
