<?php 
namespace Expertshop\Controller;
class baseController{
	protected $libraries, $arguments;
	public function __construct(array $libraries = []){
		$this->libraries = $libraries;
		$this->loadHeader();
	}
	public function twig(string $template,array $vars = []){
		$template = $this->libraries['twig']->load($template);
		$vars = array_merge(twigConstants,$vars);
		echo $template->render($vars);
	}
	public function setArguments($arguments){
		$this->arguments = $arguments;
	}
	protected function conn(){
		return $this->libraries['conn'];
	}
	public function invalid_method($controller,$method){
		echo '$controller: <b>' . $controller . '</b><br />';
		echo '<span style="color:red;">invalid</span> method: <b>' . $method . '</b>';
	}
	public function loadHeader(){
		$this->twig('elements/header.twig');
	}
	
	public function Model(string $model = ''){
		$model = $model ? $model.'Model' : $this->defaultModule;
		//dump($model);
		$model = '\Expertshop\Model\\' . $model;
		$Model = new $model($this->libraries['conn']);
		return $Model;
	}
	public function GetArguments(){
		return $this->arguments;
	}
	public function __destruct(){
		$this->loadFooter();
		
	}
	public function loadFooter(){
		$this->twig('elements/footer.twig');	
	}
	
	
}