<?php
namespace Expertshop\Model;
class baseModel {
	protected $conn;
	public function __construct(object $conn){
		$this->conn = $conn;
	}
	public function query(string $sql, array $vars = []){
		return $this->conn->query($sql,$vars);	
	}
	public function lastInsertId(){
		//return 2;
		return $this->conn->lastInsertId();		
	}
}