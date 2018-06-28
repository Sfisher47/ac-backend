<?php

/* ************************************************************************** */
/*                                                                            */
/*  error.php                                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Thu Jun 28 17:37:52 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

function	log_error($str = "", $filename = "", $line = "")
{
	if (is_string($str))
		return (0);
	echo "Error : " . $filename . " : " . $line . " : ". $str . " " . PHP_EOL;
}

?>
