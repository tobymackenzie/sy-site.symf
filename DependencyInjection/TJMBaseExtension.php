<?php
namespace TJM\Bundle\BaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TJMBaseExtension extends Extension{
	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container){
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
//var_dump($configs);die();
		$pageSkeletons = Array(
			"ajax"=> "TJMBaseBundle:base:skeletons/ajax.html.twig"
			,"iframe"=> "TJMBaseBundle:base:skeletons/iframe.html.twig"
			,"page"=> "TJMBaseBundle:base:skeletons/page.html.twig"
		);
		if(array_key_exists("page_skeletons", $config)){
			$pageSkeletons = array_merge($pageSkeletons, $config["page_skeletons"]);
		}
		$container->setParameter("tjm_base.skeletons", $pageSkeletons);
		// $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		// $loader->load('services.yml');
	}
}

