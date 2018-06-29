<?php

/* ************************************************************************** */
/*                                                                            */
/*  error.php                                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jun 29 09:17:39 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php

function	bm_error($str = "", $filename = "", $line = "")
{
	if (!is_string($str))
		return (0);
	echo "Error : " . $filename . " : " . $line . " : ". $str . " " . PHP_EOL;
}

?>
