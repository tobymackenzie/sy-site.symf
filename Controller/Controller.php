<?php
namespace TJM\Bundle\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController{
	/*==
	provide easy access to services
	==*/
	public function __get($name){
		return $this->get($name);
	}
	/*=====
	=renderers
	=====*/
	/*==
	allow adding custom functionality to rendering of pages (on override)
	==*/
	public function renderPage($view, array $parameters = array(), Response $response = null){
		$skeletons = $this->container->getParameter('tjm_base.skeletons');
		if(!array_key_exists("page", $parameters)){
			$parameters["page"] = Array();
		}
		if(!array_key_exists("skeleton", $parameters["page"])){
			if($this->request->isXmlHttpRequest()){
				$parameters["page"]["skeleton"] = $skeletons["ajax"];
			}else{
				foreach($skeletons as $name=>$skeleton){
					if(array_key_exists("is{$name}", $_REQUEST)){
						$parameters["page"]["skeleton"] = $skeleton;
					}
				}
			}
			if(!array_key_exists("skeleton", $parameters["page"])){
				$parameters["page"]["skeleton"] = $skeletons["page"];
			}
		}
		$response = $this->render($view, $parameters, $response);
		return $response;
	}
}

