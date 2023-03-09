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
}