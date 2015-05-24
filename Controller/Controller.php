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
		$wraps = $this->container->getParameter('tjm_base.wraps');
		if(!array_key_exists("wrap", $parameters["page"])){
			$request = $this->get("request");
			$get = $request->query;
			$post = $request->request;
			foreach($wraps as $name=>$skeleton){
				if(
					$get->has("_wrap_{$name}")
					|| $post->has("_wrap_{$name}")
				){
					$parameters["page"]["wrap"] = $name;
				}
			}
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
		$response = $this->render($view, $parameters, $response);
		return $response;
	}
}

