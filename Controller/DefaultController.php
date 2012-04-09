<?php
namespace TJM\Bundle\BaseBundle\Controller;

use TJM\Bundle\BaseBundle\Controller\Controller;

class DefaultController extends Controller{
	public function indexAction($name){
		return $this->render('TJMBaseBundle:default:index.html.twig', array('name' => $name));
	}
}

