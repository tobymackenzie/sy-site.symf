<?php
namespace TJM\Bundle\BaseBundle\Templating;

use Symfony\Component\Templating\Helper\Helper as BaseHelper;

/*==========
for php templating engine, helpers give access to services
==========*/
class Helper extends BaseHelper{
	/*=====
	==attributes
	=====*/
	protected $name;
	public $service;

	/*=====
	==methods
	=====*/
	public function __construct($service, $name){
		$this->service = $service;
		$this->name = $name;
	}
	public function __get($name){
		if(isset($this->service->name)){
			return $this->service->name;
		}
	}
	public function __call($name, $arguments){
		if(method_exists($this->service, $name)){
			return call_user_func_array(array($this->service, $name), $arguments);
		}
	}
	public function getName(){
		return $this->name;
	}
}
