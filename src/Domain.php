<?php
namespace Expertshop;
class Domain{
	private $response,$request,$deep;
	public function __construct($defaultControlerName='System',$defaultMethodName='Index'){
		$this->response = [
			'controllerName' => $defaultControlerName,
			'methodName' => $defaultMethodName
		];
		$this->request = explode('/',$_SERVER['REQUEST_URI']);
		$this->deep = 0;
	}
	public function set_deep(int $deep){
		$this->deep = $deep;
	}
	public function get_response(){
		//Controller
		$this->response['controllerName']=$this->validateRequest(1,'controllerName');
		$this->response['methodName']=$this->validateRequest(2,'methodName');
		$this->response['request_arguments']=$this->getArguments();
		return $this->response;
	}
	public function getArguments(){
		$index=3 + $this->deep;
		$total = count($this->request);
		$args = [];
		if($total < $index){
			return $args;	
		}else{

			for($i=$index;$i<$total+1;$i++){
				$name =  @$this->request[$i] ?: '';
				$value = @$this->request[$i+1] ?: '';
				$args[$name]=$value;
				$i++;
			}

		}
		return $args;
	}
	private function validateRequest($index,$default){
		$index+=$this->deep;
		if(isset($this->request[$index]) && $this->request[$index]!=''){
			return $this->request[$index];
		}else{
			return $this->response[$default];
		}
	}
	
}