<?php
namespace TJM\Bundle\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController{
	/*==
	provide easy access to services
	==*/
	public function __get($name) {
		return $this->get($name);
	}
	/*=====
	=renderers
	=====*/
	/*==
	allow adding custom functionality to rendering of pages (on override)
	==*/
	public function renderPage($view, array $parameters = array(), Response $response = null){
		$response = $this->render($view, $parameters, $response);
		return $response;
	}
	/*==
	render template into a skeleton
	==*/
	public function renderSkeletonPage($template, $data = Array(), $options = Array()){
		$options = array_merge(Array(
			"template"=> $template
			,"skeleton"=> "TJMBaseBundle:base:skeleton/base.html.php"
			,"skeletonAjax"=> "TJMBaseBundle:base:skeleton/ajax.html.php"
			,"loader"=> "TJMBaseBundle:Default:skeletonLoader.html.php"
		), $options);
		$data["loaderOptions"] = $options;
		$response = $this->renderPage($options["loader"], $data);
//		$response->headers->set("Content-Type", "text/html");
		return $response;
	}
}

