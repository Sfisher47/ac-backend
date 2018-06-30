<?php

/* ************************************************************************** */
/*                                                                            */
/*  error.php                                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jun 30 17:00:36 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function	bm_error($str = "", $filename = "", $line = "")
{
	if (!is_string($str))
		return (0);
	echo "Error : " . $filename . " : " . $line . " : ". $str . " " . PHP_EOL;
}

?>
