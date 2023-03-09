<?php
namespace Expertshop\Model;

use Expertshop\Model\baseModel;

class TypesModel extends baseModel{
	public function getTypes(){
		$sql = '
		SELECT
			id, name, tax
		FROM
			product_types
		';
		return $this->query($sql);
	}
	public function registerType(array $args){
		$vars = [
			'name' => $args['name'],
			'tax' => $args['tax'],
		];
		$sql = '
			INSERT INTO
				product_types
					(name,tax)
			VALUES
				(:name,:tax)
		';
		$this->query($sql,$vars);
		return $this->lastInsertId();
	}
	public function getType(array $args){
		$vars = [
			'typeId' => $args['typeId'],
		];
		$sql = '
		SELECT
			id, name, tax
		FROM
			product_types
		WHERE 
			id = :typeId
		';
		return $this->query($sql,$vars)[0];
	}
	public function editType(array $args){

		
		$vars = [
			'id' => $args['id'],
			'name' => $args['name'],
			'tax' => $args['tax'] * 1,
		];
		$sql = '
			UPDATE 
				product_types
			SET 
				name = :name,
				tax = :tax
			WHERE 
				id = :id;
		';
		
		$this->query($sql,$vars);
		
	}
}