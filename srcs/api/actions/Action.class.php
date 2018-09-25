<?php

/* ************************************************************************** */
/*                                                                            */
/*  Action.class.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Aug 05 10:19:39 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	// Import
	require_once __API_DIR__ . '/Database.class.php';

	class		FetchAction
	{
	}

	class		Action
	{
		
		private $dbc = null;
		private	static $table = "actions";
		public static	$verbose = false;
		
		private $id;
		private $title;
		private $street;
		private $addressInfo;
		private $codePostal;
		private $city;
		private $country;
		private $description;
		private $date;
		private $time;
		private $duration;
		private $userId;

// 		contructor
		public function __construct($data=null)
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
			
			$db = new Database();
			
			$this->dbc = $db->Connect();
			
			if(isset($data))
			{
				$this->HydrateFromJsonObj($data);
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
		
		public function	Create()
		{
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
				
			$stmt = $this->dbc->prepare($query);
			
			$this->Sanitize();
			
			try
			{
				$stmt->bindParam(':title', $this->title);
				$stmt->bindParam(':street', $this->street);
				$stmt->bindParam(':addressInfo', $this->addressInfo);
				$stmt->bindParam(':codePostal', $this->codePostal);
				$stmt->bindParam(':city', $this->city);
				$stmt->bindParam(':country', $this->country);
				$stmt->bindParam(':description', $this->description);
				$stmt->bindParam(':date', $this->date);
				$stmt->bindParam(':time', $this->time);
				$stmt->bindParam(':duration', $this->duration);
				$stmt->bindParam(':userId', $this->userId);
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				return false;
			}
			
			if (!$stmt->execute())
			{
				internal_error("stmt->execute : ", __FILE__, __LINE__);
				return false;
			}
			
			return true;
		}
		
		public function	Update()
		{
			$query = 'UPDATE ' . self::$table . ' SET '
			. (isset($this->title)) ? 'title = :title,' : '' 
			. (isset($this->street)) ? 'street = :street,' : ''
			. (isset($this->addressInfo)) ? 'address_info = :addressInfo,' : ''
			. (isset($this->codePostal)) ? 'postal_code = :codePostal,' : ''
			. (isset($this->city)) ? 'city = :city,' : ''
			. (isset($this->country)) ? 'coutry = :country,' : ''
			. (isset($this->description)) ? 'description = :description,' : ''
			. (isset($this->date)) ? 'date = :date,' : ''
			. (isset($this->time)) ? 'time = :time,' : ''
			. (isset($this->duration)) ? 'duration = :duration,' : ''
			. 'id = id'
			. ' WHERE id = :id';
				
			$stmt = $this->dbc->prepare($query);
			
			$this->Sanitize();
			
			try
			{
				(isset($this->id)) ? $stmt->bindParam(":id", $this->id, PDO::PARAM_INT) : false;
				(isset($this->title)) ? $stmt->bindParam(':title', $this->title) : false;
				(isset($this->street)) ? $stmt->bindParam(':street', $this->street) : false;
				(isset($this->addressInfo)) ? $stmt->bindParam(':addressInfo', $this->addressInfo) : false;
				(isset($this->codePostal)) ? $stmt->bindParam(':codePostal', $this->codePostal) : false;
				(isset($this->city)) ? $stmt->bindParam(':city', $this->city) : false;
				(isset($this->country)) ? $stmt->bindParam(':country', $this->country) : false;
				(isset($this->description)) ? $stmt->bindParam(':description', $this->description) : false;
				(isset($this->date)) ? $stmt->bindParam(':date', $this->date) : false;
				(isset($this->time)) ? $stmt->bindParam(':time', $this->time) : false;
				(isset($this->duration)) ? $stmt->bindParam(':duration', $this->duration) : false;
				(isset($this->id)) ? $stmt->bindParam(":id", $this->id, PDO::PARAM_INT) : false;
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				return false;
			}
			
			if (!$stmt->execute())
			{
				internal_error("stmt->execute : ", __FILE__, __LINE__);
				return false;
			}
			
			return true;
		}
		
		public function Delete()
		{
			$query = 'DELETE FROM ' . self::$table . ' WHERE id = :id ';
				
			$stmt = $this->dbc->prepare($query);
			
			$this->Sanitize();
			
			try
			{
				(isset($this->id)) ? $stmt->bindParam(":id", $this->id, PDO::PARAM_INT) : false;
			}
			catch (Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				return false;
			}
			
			if (!$stmt->execute())
			{
				internal_error("stmt->execute : ", __FILE__, __LINE__);
				return false;
			}
			
			return true;
		}
		
		public static function GetById($id, $hydrate=false)
		{
			$action = new Action();
			
			$query = 'SELECT * FROM ' . self::$table . ' WHERE id = :id';
			
			$db = new Database();
			$pdo = $db->Connect();
			$stmt = $pdo->prepare($query);
			try
			{
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();				
				
				if ( $hydrate )
				{
					$stmt->setFetchMode(PDO::FETCH_CLASS, 'FetchAction');
					$obj = $stmt->fetch();
					$action->HydrateFromFetchObj($obj);
				}				
				else 
				{
					$stmt->setFetchMode(PDO::FETCH_ASSOC);
					$action = $stmt->fetch();
				}
			}
			catch(Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				return (false);
			}
			
			return $action;
		}
		
		public static function GetAll($hydrate=false)
		{
			$actions = array();
			
			$query = 'SELECT * FROM ' . self::$table;
			
			$db = new Database();
			$pdo = $db->Connect();
			$stmt = $pdo->prepare($query);
			try
			{
				$stmt->execute();				
				
				if ( $hydrate )
				{
					$ret = $stmt->fetchAll(PDO::FETCH_CLASS, 'FetchAction');				
					foreach($ret as $key => $obj)
					{
						$action = new Action();
						$action->HydrateFromFetchObj($obj);
						array_push($actions, $action);
					}
				}				
				else 
				{
					$actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				
			}
			catch(Exception $e)
			{
				internal_error("stmt->bindParam : " . $e->getMessage(),
								__FILE__, __LINE__);
				return (false);
			}
			
			return $actions;
		}
		
		public function Sanitize()
		{						
			$this->id = htmlspecialchars(strip_tags(trim($this->id)));
			$this->title = htmlspecialchars(strip_tags(trim($this->title)));
			$this->street = htmlspecialchars(strip_tags(trim($this->street)));
			$this->addressInfo = htmlspecialchars(strip_tags(trim($this->addressInfo)));
			$this->codePostal = htmlspecialchars(strip_tags(trim($this->codePostal)));
			$this->city = htmlspecialchars(strip_tags(trim($this->city)));
			$this->country = htmlspecialchars(strip_tags(trim($this->country)));
			$this->description = htmlspecialchars(strip_tags(trim($this->description)));
			$this->date = htmlspecialchars(strip_tags(trim($this->date)));
			$this->time = htmlspecialchars(strip_tags(trim($this->time)));
			$this->duration = htmlspecialchars(strip_tags(trim($this->duration)));
			$this->userId = htmlspecialchars(strip_tags(trim($this->userId)));
			
			return $this;
		}
		
		public function HydrateFromJsonObj($data)
		{			
			$this->id = (isset($data->id)) ? $data->id : null ;
			$this->title = (isset($data->title)) ? $data->title : null ;
			$this->street = (isset($data->street)) ? $data->street : null ;
			$this->addressInfo = (isset($data->address_info)) ? $data->address_info : null ;
			$this->codePostal = (isset($data->postal_code)) ? $data->postal_code : null ;
			$this->city = (isset($data->city)) ? $data->city : null ;
			$this->country = (isset($data->country)) ? $data->country : null ;
			$this->description = (isset($data->description)) ? $data->description : null ;
			$this->date = (isset($data->date)) ? $data->date : null ;
			$this->time = (isset($data->time)) ? $data->time : null ;
			$this->duration = (isset($data->duration)) ? $data->duration : null ;
			$this->userId = (isset($data->user_id)) ? $data->user_id : null ;	
			
			return $this;
		}
		
		public function HydrateFromFetchObj($data)
		{			
			$this->id = (isset($data->id)) ? $data->id : null ;
			$this->title = (isset($data->title)) ? $data->title : null ;
			$this->street = (isset($data->street)) ? $data->street : null ;
			$this->addressInfo = (isset($data->address_info)) ? $data->address_info : null ;
			$this->codePostal = (isset($data->postal_code)) ? $data->postal_code : null ;
			$this->city = (isset($data->city)) ? $data->city : null ;
			$this->country = (isset($data->coutry)) ? $data->coutry : null ;
			$this->description = (isset($data->description)) ? $data->description : null ;
			$this->date = (isset($data->date)) ? $data->date : null ;
			$this->time = (isset($data->time)) ? $data->time : null ;
			$this->duration = (isset($data->duration)) ? $data->duration : null ;
			$this->userId = (isset($data->user_id)) ? $data->user_id : null ;	
			
			return $this;
		}
		
		public function HydrateFromJsonObjAndSinitize($data)
		{
			$this->hydrateFromJsonObj($data);
			$this->Sanitize();
			
			return $this;
		}	

	}
?>
