<?php
namespace TJM\Bundle\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController{
	/*=====
	=renderers
	=====*/
	/*==
	allow adding custom functionality to rendering of pages (on override)
	==*/
	public function renderPage($view, array $parameters = array(), Response $response = null){
		if(!array_key_exists("page", $parameters)){
			$parameters["page"] = Array();
		}
		$request = (isset($parameters['request'])) ? $parameters['request'] : $this->get("request");
		if(!isset($parameters["page"]["skeleton"])){
			$wraps = $this->container->getParameter('tjm_base.wraps');
			if(!array_key_exists("wrap", $parameters["page"])){
				if(!array_key_exists("wrap", $parameters["page"])){
					if(
						array_key_exists("bare", $wraps)
						&& $request->isXmlHttpRequest()
					){
						$parameters["page"]["wrap"] = "bare";
					}else{
						$parameters["page"]["wrap"] = "full";
					}
				}
			}
			$parameters["page"]["skeleton"] = array_key_exists($parameters["page"]["wrap"], $wraps)
				? $wraps[$parameters["page"]["wrap"]]
				: $wraps["full"]
			;
		}
		$parameters['page']['skeleton'] = str_replace('{format}', $request->getRequestFormat() , $parameters['page']['skeleton']);
		$response = $this->render($view, $parameters, $response);
		return $response;
	}
}

