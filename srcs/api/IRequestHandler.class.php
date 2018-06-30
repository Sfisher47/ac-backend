<?php

/* ************************************************************************** */
/*                                                                            */
/*  IRequestHandler.class.php                                                 */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jun 30 14:36:33 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	interface	IRequestHandler
	{
		public	function	Post($db);
		public	function	Get($db);
		public	function	Put($db);
		public	function	Delete($db);
		public	function	Update($db);
	}

?>
