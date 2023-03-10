<?php
namespace Expertshop\Model;

use Expertshop\Model\baseModel;

class StoreSystemModel extends baseModel{
	public function getProducts(){
		$sql = '
		SELECT
			P.id, P.name, P.price, P.type, P.photo, T.name as type_name, T.tax As type_tax
		FROM
			products P, product_types T
		WHERE
			P.type = T.id
		';
		return $this->query($sql);
	}
	public function getProductsByIds($ids){
		$in_list = '';
		foreach($ids as $id){
			$in_list.='"'.$id.'", ';
		}
		$in_list =substr($in_list,0,-2);
		$sql = '
		SELECT
			P.id, P.name, P.price, P.type, P.photo, T.name as type_name, T.tax As type_tax
		FROM
			products P, product_types T
		WHERE
			P.type = T.id &&
			P.id IN ('.$in_list.')

		';
		$products  = $this->query($sql);
		if(count($products)){
			$return = [];
			foreach($products as $product){
				$return[$product['id']] = $product;
			}

		}
		return 	$return;

	}
	public function getProduct(array $args){
		$vars = [
			'productId' => $args['productId'],
		];
		$sql = '
		SELECT
			P.id, P.name, P.price, P.type, P.photo, P.description, T.name as type_name, T.tax As type_tax
		FROM
			products P, product_types T
		WHERE
			P.type = T.id && P.id  = :productId
		LIMIT 1
		';
		return $this->query($sql,$vars)[0];

	}
	public function registerProduct(array $args){
		
		$vars = [
			'name' => $args['name'],
			'price' => $args['price']*1,
			'type' => $args['type']*1,
			'photo' => $this->UploadPhoto('photo'),
			'description' => $args['description']
		];
		$sql = '
			INSERT INTO
				products
					(name,price,type,description,photo)
			VALUES
				(:name,:price,:type,:description,:photo)
		';
		
		$this->query($sql,$vars);
		return $this->lastInsertId();
		
	}
	public function UploadPhoto($field){
		$photo = [
			'tmp_name' => $_FILES[$field]['tmp_name'],
			'original' => $_FILES[$field]['name']
		];

		if($photo['tmp_name'] != ''){
			$dot = strrpos($photo['original'],'.');
			$name = substr( $photo['original'],0,$dot );
			$ext = substr( $photo['original'], $dot) ;
			$number = '';
			$file = FilesDirectory.$name.$number.$ext;
			while(is_file($file)){
				$number++;
				$file = FilesDirectory.$name.'__'.$number.$ext;
			}
			move_uploaded_file($photo['tmp_name'], $file);
			return substr($file,1);		
		}
		return '';
		

	}
	public function savingProduct(array $args){
		print_r($_POST);
		$vars = [
			'id' => $args['id'],
			'name' => $args['name'],
			'price' => $args['price'] * 1,
			'type' => $args['type'] * 1,
			'description' => $args['description'],
		];
		$sql = '
			UPDATE products 
			SET 
				name = :name,
				price = :price,
				type = :type,
				description = :description
			WHERE 
				id = :id;
		';
		$this->query($sql,$vars);

		$photo = $this->UploadPhoto('photo');
		if($photo!=''){

			$updatePhoto = [
				'id' => $args['id'],
				'photo' => $photo,
			];
			$sql = '
			UPDATE products 
				SET 
					photo = :photo
				WHERE 
					id = :id;
			';
			$this->query($sql,$updatePhoto);
		}
		return $this->lastInsertId();
	}
	public function SaveCart(array $cart){
		$cart_serialized = serialize($cart);
		$sql = '
			INSERT INTO
				cart
					(serialized)
			VALUES
				(:serialized)
		';
		$vars = [
			'serialized' => $cart_serialized
		];
		$this->query($sql,$vars);
		$savedCart = $this->lastInsertId();
		echo '<pre>';
		print_r($cart);
		echo '</pre>';

	}
	public function getProdutcsToSave(array $products){
		return array_keys($products);
	}
	public function productsFormat(array $cart, array $products,object $cartModel){
		$total = 0;
		foreach($cart as $productsId => $qtd){
			if(!isset($products[$productsId])) continue;
			$product = $products[$productsId];
			$products[$productsId]['qtd'] = $qtd;
			$subtotal = $cartModel->calcFullPrice($product['price'],$product['type_tax'],$qtd);
			$products[$productsId]['subtotal'] = $subtotal;
			$total += $subtotal;
		}
		return $products;

	}
}