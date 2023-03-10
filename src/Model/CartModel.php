<?php
namespace Expertshop\Model;

class CartModel{
	public function AddToCart(array $product){
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = [];
		}
		if(isset($_SESSION['cart'][$product['id']])){
			$_SESSION['cart'][$product['id']] += $product['qtd'];
		}else{
			$_SESSION['cart'][$product['id']] = $product['qtd'];
		}
	}
	public function getCart(){
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = [];
		}
		return $_SESSION['cart'];
	}
	public function calcFullPrice(float $price, float $tax,$qtd = 1){
		return ($price + (($price/100)*$tax) )* $qtd;
	}
		
}