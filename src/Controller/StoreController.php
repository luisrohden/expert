<?php
namespace Expertshop\Controller;

use Expertshop\Controller\baseController;

class StoreController extends baseController{
	protected $defaultModule = 'StoreSystemModel';
	public function Index(){
		$vars = [
			'products' => $this->Model()->getProducts(),
		];
		$this->twig('store.twig',$vars);
	}
	public function view(){
		$vars = [
			'productId' => $this->arguments['product'] * 1,
		];
		$product = $this->Model()->getProduct($vars);
		$this->twig('view.twig',$product);
		

	}
	public function Cart(){
		$cart = $this->Model('Cart')->getCart();
		if(count($cart)){

			$productsIds = array_keys($cart);
			$products = $this->Model()->getProductsByIds($productsIds);
			$products = $this->Model()->productsFormat($cart,$products,$this->Model('Cart'));
			
			$vars = [
				'products' => $products,
			];
			$this->twig('cart.twig',$vars);
			

		}
	}
	public function AddToCart(){
		if(count($_POST)){
			$this->Model('Cart')->AddToCart($_POST);	
		}
		$this->Cart();
		
		
	}
	public function SaveCart(){
		$productsIds = $this->Model()->getProdutcsToSave($_POST['prod']);
		$products = $this->Model()->getProductsByIds($productsIds);
		$products = $this->Model()->productsFormat($_POST['prod'],$products,$this->Model('Cart'));
		$this->Model()->SaveCart($products);

	}
}