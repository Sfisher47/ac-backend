<?php

/* ************************************************************************** */
/*                                                                            */
/*  index.php                                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jun 28 14:15:31 2018                        by elhmn        */
/*   Updated: Thu Nov 29 12:14:46 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

define('__API_DIR__', dirname(__FILE__) . '/srcs/api');

require_once('srcs/errors/HttpError.class.php');
require_once('srcs/errors/error.php');
require_once('srcs/api/Uri.class.php');
require_once('srcs/api/Auths.class.php');
require_once('srcs/api/Database.class.php');
require_once('srcs/api/IRequestHandler.class.php');
require_once('srcs/api/users/UserPostUtilities.class.php');
require_once('srcs/api/users/UserRequest.class.php');
require_once('srcs/api/Config.class.php');
require_once('srcs/api/router.php');

header("Access-Control-Allow-Origin: *");

?>
