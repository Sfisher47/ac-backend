<?php

/* ************************************************************************** */
/*                                                                            */
/*  IRequestHandler.class.php                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jun 29 15:30:35 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

?>

<?php
	interface	IRequestHandler
	{
		public	function	Post();
		public	function	Get();
		public	function	Put();
		public	function	Delete();
		public	function	Update();
	}
?>
