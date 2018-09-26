<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserPostUtilities.class.php                                               */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Aug 05 09:27:59 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */


class		ActionRequestUtilities
{
	public static function		SanitizeData($data)
	{
		if (!$data)
		{
			internal_error("data set to null", __FILE__, __LINE__);
			return(null);
		}
		
		$data->id = (isset($data->id)) ? htmlspecialchars(strip_tags(trim($data->id))) : null ;
		$data->title = (isset($data->title)) ? htmlspecialchars(strip_tags(trim($data->title))) : null ;
		$data->street = (isset($data->street)) ? htmlspecialchars(strip_tags(trim($data->street))) : null ;
		$data->addressInfo = (isset($data->address_info)) ? htmlspecialchars(strip_tags(trim($data->address_info))) : null ;
		$data->codePostal = (isset($data->postal_code)) ? htmlspecialchars(strip_tags(trim($data->postal_code))) : null ;
		$data->city = (isset($data->city)) ? htmlspecialchars(strip_tags(trim($data->city))) : null ;
		$data->country = (isset($data->country)) ? htmlspecialchars(strip_tags(trim($data->country))) : null ;
		$data->description = (isset($data->description)) ? htmlspecialchars(strip_tags(trim($data->description))) : null ;
		$data->date = (isset($data->date)) ? htmlspecialchars(strip_tags(trim($data->date))) : null ;
		$data->time = (isset($data->time)) ? htmlspecialchars(strip_tags(trim($data->time))) : null ;
		$data->duration = (isset($data->duration)) ? htmlspecialchars(strip_tags(trim($data->duration))) : null ;
		$data->userId = (isset($data->user_id)) ? htmlspecialchars(strip_tags(trim($data->user_id))) : null ;

		return ($data);
	}

};

?>
