<?php
namespace Expertshop\Controller;

use Expertshop\Controller\baseController;
use Expertshop\Model\ProjectModel;

class TypesController extends baseController{
	protected $defaultModule = 'TypesModel';
	public function Index(){

		$vars = [
			'typeList' => $this->Model()->getTypes(),
		];
		$this->twig('types/list.twig',$vars);		

	}
	public function AddType(){
		
		$this->twig('types/add.twig');

	}
	public function AddingType(){
		$inserted = $this->Model()->registerType($_POST);
		if($inserted){
			$vars = [
				'typeName' => $_POST['name'],
				'typeId' => $inserted,
			];
			$this->twig('types/added.twig',$vars);
		}else{

		}
		$this->Index();
	}
	public function edit(){
		$args = [
			'typeId' => ( $this->arguments['typeId'] * 1 )
		];
		$type = $this->Model()->getType($args);

		

		$this->twig('types/edit.twig',$type);
	}
	public function savingType(){
		$edit = $this->Model()->editType($_POST);
		$vars = [
			'typeName' => $_POST['name'],
		];
		$this->twig('types/edited.twig',$vars);
		$this->Index();

	}
}