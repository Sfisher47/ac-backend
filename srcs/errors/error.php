<?php

/* ************************************************************************** */
/*                                                                            */
/*  error.php                                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jul 07 10:10:42 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function	internal_error($str = "", $filename = "", $line = "")
{
	if (!is_string($str))
		return (-1);
	error_log(format_error($str, $filename, $line), 3, Config::getInstance()->$error_log_file);
}

//Send HttpError after internal error
function	http_internal_error($str = "", $filename = "",
								$line = "", $code = 500, $messageIndex = 1)
{
	http_error($code, $messageIndex);
	if (!is_string($str))
		return (-1);
	error_log(format_error($str, $filename, $line), 3, Config::getInstance()->$error_log_file);
}

function	format_error($str = "", $filename = "", $line = "")
{
	return (date("Y-m-d H.i.s") . " : Error : "
				. $filename
				. " : "
				. $line
				. " : "
				. $str
				. " "
				. PHP_EOL);
}

function	http_error($code, $message = "", $messageIndex = 1)
{
	if (!is_numeric($code))
	{
		internal_error("'$code' is not numeric code", __FILE__, __LINE__);
		return (-1);
	}
	http_response_code($code);
	echo "{ \"error\" : "
		. HttpError::$errorCodes[$code][0]
			."\","
			. " \"message\" : \""
			. (empty($message) ?
				HttpError::$errorCodes[$code][$messageIndex]
				: $message)
			. "\"}"
			. PHP_EOL;
}

?>
