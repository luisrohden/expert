<?php
namespace Expertshop\Controller;

use Expertshop\Controller\baseController;
//use Expertshop\Model\ProjectModel;

class StoreSystemController extends baseController{
	protected $defaultModule = 'StoreSystemModel';
	public function Index(){
		$vars = [
			'products' => $this->Model()->getProducts(),
		];
		$this->twig('products/list.twig',$vars);
	}
	public function addProduct(){
		$vars = [
			'typesList' => $this->Model('Types')->getTypes()
		];
		
		$this->twig('products/add.twig',$vars);

	}
	public function addingProduct(){
		$productId = $this->Model()->RegisterProduct($_POST);
		if($productId){
			$vars = [
				'productName' => $_POST['name'],
				'productId' => $productId,
			];
			$this->twig('products/added.twig',$vars);
		}
		$this->Index();
	}
	public function edit(){
		
		$args = [
			'productId' => ( $this->arguments['productId'] * 1 )
		];
		$vars = [
			'typesList' => $this->Model('Types')->getTypes(),
		];
		$product = $this->Model()->getProduct($args);

		$vars = array_merge($vars,$product);

		$this->twig('products/edit.twig',$vars);
	}

	public function savingProduct(){
		$edit = $this->Model()->savingProduct($_POST);
		$vars = [
			'productName' => $_POST['name'],
		];
		$this->twig('products/edited.twig',$vars);
		$this->Index();

	}

	
}