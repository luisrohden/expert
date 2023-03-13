<?php
namespace Expertshop;

class Conn{
	private $status;
	public function __construct($MysqlAccess){
		$this->setDB($MysqlAccess);
	}
	public function setDB($MysqlAccess){
		$this->status = false;
		$this->MysqlAccess = $MysqlAccess;
	}
	public function connect(){
		if($this->status){
			return true;
		}
		extract($this->MysqlAccess);
		try{

			pgsql
			mysql
			$db_type
			
			$this->conn = new \PDO($db_type':host=' . $db_host . ';dbname=' . $db_name,$db_user,$db_password);
			$this->status = true;
			return true;
		}
		catch(\PDOExeption $e) {
			$msg = 'PDO ERROR <hr />';
			dump($e);
			die();
		}
	}
	public function lastInsertId(){
		return $this->conn->lastInsertId() * 1;
	}
	public function query($sql,$bind){

		if(!$this->status){
			$this->connect();
		}
		
		$smtp = $this->conn->prepare($sql);

		try {
			$smtp->execute($bind);	
			$result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
		}
		catch(\PDOExeption $e) {
			$result = $e;
		}
		return $result;
	}
}