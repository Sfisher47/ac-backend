<?php

/* ************************************************************************** */
/*                                                                            */
/*  UserRequest.class.php                                                     */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Oct 27 17:44:19 2018                        by u89115211    */
/*                                                                            */
/* ************************************************************************** */


	class		ActionDBRequest
	{
		private	static		$table = "Actions";
		private static 		$errMessage = "";
		public static			$verbose = false;

// 		contructor
		public function __construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
		}

// 		destructor
		public function __destruct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " destructor called !" . PHP_EOL;
			}
		}
		
		public static function		GetErrMessage()
		{
				return self::$errMessage;
		}
		
		//-- READ --
		
		public static function		GetAll($db, $userId)
		{
			self::$errMessage = "";
			
			$query = 'SELECT * FROM ' . self::$table;

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!$ret)
			{
				return (0);
			}
			
			return $ret;

		}
		
		public static function		GetOne($db, $id)
		{
			self::$errMessage = "";
			
			$query = "SELECT * FROM " . self::$table . " WHERE id = $id";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!$ret)
			{
				return (0);
			}
			
			return $ret;

		}
		
		public static function		GetAllByUser($db, $userId)
		{
			self::$errMessage = "";
			
			$query = 'SELECT * FROM ' . self::$table . " WHERE user_id = $userId";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!$ret)
			{
				return (0);
			}
		
			return $ret;

		}
		
		public static function		GetOneByUser($db, $id, $userId)
		{
			self::$errMessage = "";
			
			$query = "SELECT * FROM " . self::$table . " WHERE id = $id AND user_id = $auth->userid";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			$stmt->execute();
			$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!$ret)
			{
				return (0);
			}
			
			return $ret;

		}
		
		//-- CREATE --
		
		public static function		Create($db, $data)
		{
			self::$errMessage = "";
			
			$query = 'INSERT INTO ' . self::$table . ' SET
			title = :title,
			street = :street,
			address_info = :addressInfo,
			postal_code = :codePostal,
			city = :city,
			coutry = :country,
			description = :description,
			date = :date,
			time = :time,
			duration = :duration,
			user_id = :userId;';

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			try
			{
				$stmt->bindParam(':title', $data->title);
				$stmt->bindParam(':street', $data->street);
				$stmt->bindParam(':addressInfo', $data->address_info);
				$stmt->bindParam(':codePostal', $data->postal_code);
				$stmt->bindParam(':city', $data->city);
				$stmt->bindParam(':country', $data->country);
				$stmt->bindParam(':description', $data->description);
				$stmt->bindParam(':date', $data->date);
				$stmt->bindParam(':time', $data->time);
				$stmt->bindParam(':duration', $data->duration);
				$stmt->bindParam(':userId', $auth->userid);

			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				
				self::$errMessage = $e->getMessage();
				return (false);
			}

			try
			{
				$stmt->execute();
			}
			catch (Exception $e)
			{
				internal_error("stmt->execute : ". $e->getMessage(), __FILE__, __LINE__);
				self::$errMessage = $e->getMessage();
				return (false);
			}
			
			return true;
			
		}

		//-- UPDATE --
		
		public static function		Update($db, $data)
		{			
			self::$errMessage = "";
			
			$query = 'UPDATE ' . self::$table . ' SET '
			. ((isset($data->title)) ? 'title = :title,' : '')
			. ((isset($data->street)) ? 'street = :street,' : '')
			. ((isset($data->address_info)) ? 'address_info = :addressInfo,' : '')
			. ((isset($data->postal_code)) ? 'postal_code = :codePostal,' : '')
			. ((isset($data->city)) ? 'city = :city,' : '')
			. ((isset($data->country)) ? 'coutry = :country,' : '')
			. ((isset($data->description)) ? 'description = :description,' : '')
			. ((isset($data->date)) ? 'date = :date,' : '')
			. ((isset($data->time)) ? 'time = :time,' : '')
			. ((isset($data->duration)) ? 'duration = :duration,' : '')
			. 'id = id'
			. ' WHERE id = :id';

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			try
			{
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
				(isset($data->title)) ? $stmt->bindParam(':title', $data->title) : false;
				(isset($data->street)) ? $stmt->bindParam(':street', $data->street) : false;
				(isset($data->address_info)) ? $stmt->bindParam(':addressInfo', $data->address_info) : false;
				(isset($data->postal_code)) ? $stmt->bindParam(':codePostal', $data->postal_code) : false;
				(isset($data->city)) ? $stmt->bindParam(':city', $data->city) : false;
				(isset($data->country)) ? $stmt->bindParam(':country', $data->country) : false;
				(isset($data->description)) ? $stmt->bindParam(':description', $data->description) : false;
				(isset($data->date)) ? $stmt->bindParam(':date', $data->date) : false;
				(isset($data->time)) ? $stmt->bindParam(':time', $data->time) : false;
				(isset($data->duration)) ? $stmt->bindParam(':duration', $data->duration) : false;
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				self::$errMessage = $e->getMessage();
				return (false);
			}

			try
			{
				$stmt->execute();
			}
			catch (Exception $e)
			{
				internal_error("stmt->execute : ". $e->getMessage(), __FILE__, __LINE__);
				self::$errMessage = $e->getMessage();
				return (false);
			}
			
			return true;
		}
		
		
		//-- DELETE --

		public static function		Delete($db, $id)
		{
			self::$errMessage = "";
			
			$query = "DELETE FROM " . self::$table . " WHERE id = :id";

			$conn = $db->Connect();
			$stmt = $conn->prepare($query);

			try
			{
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
							__FILE__, __LINE__);
				self::$errMessage = $e->getMessage();
				return (false);
			}

			try
			{
				$stmt->execute();
			}
			catch (Exception $e)
			{
				internal_error("stmt->execute : " . $e->getMessage(), __FILE__, __LINE__);
				self::$errMessage = $e->getMessage();
				return (false);
			}
			
			return true;

		}
	}
?>
