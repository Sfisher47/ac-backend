<?php

/* ************************************************************************** */
/*                                                                            */
/*  router.php                                                                */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:18:29 2018                        by elhmn        */
/*   Updated: Mon Nov 26 16:16:15 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

// Import
require_once __API_DIR__ . '/actions/ActionRequest.class.php';
require_once __API_DIR__ . '/extras/ExtraRequest.class.php';
require_once __API_DIR__ . '/laborneeds/LaborNeedRequest.class.php';
require_once __API_DIR__ . '/actions/ActionPubRequest.class.php';
require_once __API_DIR__ . '/extras/ExtraPubRequest.class.php';

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
				Config::GetInstance()->apiVersions) === FALSE)
	{
		internal_error("wrong apiVersion : $uri->apiVersion",
						__FILE__, __LINE__);
		http_error(400, 'wrong api version');
		return false;
	}

	if (empty($uri->apiType)
		|| array_search($uri->apiType, Config::GetInstance()->apiTypes) === FALSE)
	{
		internal_error("require an api type ",
						__FILE__, __LINE__);
		http_error(400, 'require an api type');
		return false;
	}

	if ($uri->apiType === "private" && empty($uri->apiKey))
	{
		internal_error("require an api key ",
						__FILE__, __LINE__);
		http_error(400, 'require an api key');
		return false;
	}

	if (empty($uri->endPoint)
		|| array_search($uri->endPoint,
				Config::GetInstance()->endPoints) === FALSE)
	{
		internal_error("wrong endPoint : $uri->endPoint",
						__FILE__, __LINE__);
		http_error(400, 'wrong endPoint');
		return false;
	}
	if (empty($uri->method)
		|| array_search($uri->method,
				Config::GetInstance()->methods) === FALSE)
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
	//Check if token already property_exists
	$queryToken = "SELECT token, userid FROM $tableName WHERE token='$token'";
	try
	{
		$stmtToken = $conn->prepare($queryToken);
		$stmtToken->execute();
		$ret = $stmtToken->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1 && !empty($ret[0]))
			$auth = $ret[0];
	}
	catch(Exception $e)
	{
		internal_error("stmtToken : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (null);
	}

	//get Authorization
	$db = new Database();
	if (!$db)
	{
		internal_error('DataBase set to null', __FILE__, __LINE__);
		return (null);
	}
	if (!($conn = $db->Connect()))
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (null);
	}

	//Get authorization
	$queryAuth = "SELECT postmethod, patchmethod, getmethod, delmethod FROM Users WHERE id='${auth['userid']}'";
	try
	{
		$stmtAuth = $conn->prepare($queryAuth);
		$stmtAuth->execute();
		$ret = $stmtAuth->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1 && !empty($ret[0]))
			return ((object)array_merge($auth, $ret[0]));
	}
	catch(Exception $e)
	{
		internal_error("stmtAuth : " . $e->getMessage(),
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
	$db->host = Config::GetInstance()->authHost;
	$db->dbName = Config::GetInstance()->authDBName;
	$db->dbPassword = Config::GetInstance()->authDBPassword;
	$db->dbUserName = Config::GetInstance()->authDBUserName;
	if (!($conn = $db->Connect()))
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (null);
	}
	return (GetTokenField($conn, 'tokens', $apiKey));
}

function		IsAuthorized($uri)
{
	if ($uri->apiType === "public")
	{
		$authorizations = (object) [
			"postmethod" => Auths::NONE,
			"getmethod" => Auths::NONE,
			"patchmethod" => Auths::NONE,
			"delmethod" => Auths::NONE,
		];

		return ($authorizations);
	}

	//This case is only used for testing purposes and must never be in producttion
	if ($uri->apiKey === Config::GetInstance()->testApiKey)
	{
		$authorizations = (object) [
			"postmethod" => Auths::ALL,
			"getmethod" => Auths::ALL,
			"patchmethod" => Auths::ALL,
			"delmethod" => Auths::ALL,
		];

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

function		HandleRequest($uri, $db, $authorizations)
{
	if ($uri->apiType === "public")
	{
		$request = [
			'actions' => 'ActionPubRequest',
			'extras' => 'ExtraPubRequest',
		];
	}
	else if ($uri->apiType === "private")
	{
		$request = [
			'users' => 'UserRequest',
			'actions' => 'ActionRequest',
			'extras' => 'ExtraRequest',
			'laborneeds' => 'LaborNeedRequest',
		];
	}

	$methods = [
		'post' => 'Post',
		'get' => 'Get',
		'patch' => 'Patch',
		'delete' => 'Delete',
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

	$elem = new $request[$uri->endPoint]($db);
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
		$uri = new Uri("v1/private/"
				. Config::GetInstance()->testApiKey
				. "/users", "get");
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
