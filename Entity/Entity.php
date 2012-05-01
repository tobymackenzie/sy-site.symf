<?php
namespace TJM\Bundle\BaseBundle\Entity;

class Entity{
	public function __toString(){
		$return = "[Instance of Class: ".get_class($this);
		if(method_exists($this, "getId")){
			$return .= ", id: {$this->getId()}";
		}
		if(method_exists($this, "getName")){
			$return .= ", name: {$this->getName()}";
		}
		$return .= "]";
		return $return;
	}
}
