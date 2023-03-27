<?php
namespace TJM\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController{
	protected function getGlobalRenderData(array $parameters = Array()){
		if(!array_key_exists("page", $parameters)){
			$parameters["page"] = Array();
		}
		$request = (isset($parameters['request'])) ? $parameters['request'] : $this->container->get("request_stack")->getCurrentRequest();
		if(!isset($parameters["page"]["shell"])){
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
			$parameters["page"]["shell"] = array_key_exists($parameters["page"]["wrap"], $wraps)
				? $wraps[$parameters["page"]["wrap"]]
				: $wraps["full"]
			;
		}
		$parameters['page']['shell'] = str_replace('{format}', $request->getRequestFormat() , $parameters['page']['shell']);
		if(!isset($parameters['doc'])){
			$parameters['doc'] = Array();
		}
		if(!isset($parameters['doc']['attr'])){
			$parameters['doc']['attr'] = '';
		}
		if($parameters['doc']['attr']){
			$parameters['doc']['attr'] .= ' ';
		}
		if(!isset($parameters['doc']['language'])){
			$parameters['doc']['language'] = 'en';
		}
		if(strpos($parameters['doc']['attr'], 'lang=') === false){
			$parameters['doc']['attr'] .= 'lang="' . $parameters['doc']['language'] . '"';
		}
		if($request->getRequestFormat() === 'xhtml'){
			if(strpos($parameters['doc']['attr'], 'xmlns=') === false){
				$parameters['doc']['attr'] .= ' xmlns="http://www.w3.org/1999/xhtml" xml:lang="' . $parameters['doc']['language'] . '"';
			}
		}
		return $parameters;
	}
	/*=====
	=renderers
	=====*/
	/*==
	allow adding custom functionality to rendering of pages (on override)
	==*/
	public function renderPage($view, array $parameters = array(), Response $response = null){
		$parameters = $this->getGlobalRenderData($parameters);
		$response = $this->render($view, $parameters, $response);
		return $response;
	}
}
