<?php
namespace TJM\Bundle\BaseBundle\Extension;
/*
Class: AssetsExtension
Extends Symfony's AssetsExtension to allow using Assetic's 'write_to' parameter to change the path assets are written to.
*/

use Symfony\Bundle\TwigBundle\Extension\AssetsExtension as Base;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AssetsExtension extends Base{
	protected $container;
	public function __construct(ContainerInterface $container){
		$this->container = $container;
	}
	public function getAssetUrl($path, $packageName = null, $absolute = false, $version = null){
		$url = $this->container->get('templating.helper.assets')->getUrl($path, $packageName, $version);
		if(!$packageName && preg_match("/^(css|images|js)\//", $path)){
			$assetBase = str_replace($this->container->getParameter('kernel.root_dir') . '/../web', '', $this->container->getParameter('assetic.write_to'));
			$url = "{$assetBase}{$url}";
		}
		if($absolute){
			$url = $this->ensureUrlIsAbsolute($url);
		}
		return $url;
	}

	/*
	Hack, `getAssetUrl()` needs this but parent is private and so is the `context` that is used by it.
	*/
	protected function ensureUrlIsAbsolute($url){
		if(!(strpos($url, '://') !== false || strpos($url, '//') === 0)){
			if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])){
				$urlRoot = $_SERVER['HTTP_X_FORWARDED_PROTO'];
			}else{
				$urlRoot = 'http';
				if($_SERVER["HTTPS"] === 'on'){
					$urlRoot .= 's';
				}
			}
			$urlRoot .= '://' . $_SERVER['SERVER_NAME'];
			if((int) $_SERVER["SERVER_PORT"] !== 80){
				$urlRoot .= ':' . $_SERVER["SERVER_PORT"];
			}
			$url = $urlRoot . '/' . $url;
		}
		return $url;
	}
}
