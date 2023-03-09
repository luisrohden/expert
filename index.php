<?php
include ('inc/config.php');
include('vendor/autoload.php');

use Expertshop\Domain;
use Expertshop\Conn;

$defaultControllerName = 'Store';

$Domain = new Domain($defaultControllerName);
extract($Domain->get_response());

//twig
$loader = new \Twig\Loader\FilesystemLoader('templates');

$libraries = [
	'twig' => new \Twig\Environment($loader),
	'conn' => new \Expertshop\Conn(mysqlAcess),
];

$controller = '\Expertshop\Controller\\' . $controllerName .  'Controller';



if(class_exists($controller)){
	//echo 'controller exist<hr />';
	$obj = new $controller($libraries);
	if(method_exists($obj,$methodName)){
		$obj->setArguments($request_arguments);
		$obj->$methodName();
	}else{
		$obj->invalid_method($controller,$method);		
	}
}else{
	//echo 'controller <b>not</b>gexist<hr />';
	$controller = '\Expertshop\Controller\\' . $defaultControllerName .  'Controller';	
	if(class_exists($controller)){
		$obj = new $controller($libraries);
		$request_arguments = array_merge([$methodName],$request_arguments);
		$methodName = $controllerName;
		if(method_exists($obj,$methodName)){

			$obj->setArguments($request_arguments);
			$obj->$methodName();
		}else{
			$obj->invalid_method($controller,$methodName);		
		}
	}
	else{
		print($controller);
		echo '<br />';
		print($methodName);

	}
}
?>



