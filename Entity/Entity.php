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
	/*=====
	==attribute functions
	=====*/
	public function add($argAttribute, $argItem){
		if(method_exists($this, "add".ucfirst($argAttribute)))
			return call_user_func(Array($this, "add{$argAttribute}", $argItem));
		if(
			get_class($this->argAttribute) === "Doctrine\Common\Collections\ArrayCollection"
			|| is_array($this->argAttribute)
		){
			$this->{$argAttribute}[] = $argItem;
			return $this;
		}else{
			throw new Exception("Entity->add({$argAttribute},{$argItem}: \$argItem must be an array or doctrine collection)");
		}
	}
	/*
	test trueness of attribute
	*/
	public function is($argAttribute){
		if(method_exists($this, "is".ucfirst($argAttribute)))
			return call_user_func(Array($this, "is{$argAttribute}"));
		return ($argAttribute) ? true : false;
	}
	public function get($argAttribute){
		if(method_exists($this, "get".ucfirst($argAttribute)))
			return call_user_func(Array($this, "add{$argAttribute}"));
		return (isset($this->$argAttribute)) ? $this->$argAttribute : null;
	}
	public function set($argAttribute, $argValue){
		if(method_exists($this, "set".ucfirst($argAttribute)))
			return call_user_func(Array($this, "add{$argAttribute}", $argValue));
		$this->$argAttribute = $argValue;
		return $this;
	}
}
