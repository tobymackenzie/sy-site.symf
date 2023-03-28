<?php
namespace TJM\SySite\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TJMSySiteExtension extends Extension{
	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container){
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
//var_dump($configs);die();
		$pageWraps = Array(
			"bare"=> "@TJMSySite/shells/bare.html.twig"
			,"simple"=> "@TJMSySite/shells/simple.html.twig"
			,"full"=> "@TJMSySite/shells/full.html.twig"
		);
		if(array_key_exists("page_wraps", $config)){
			$pageWraps = array_merge($pageWraps, $config["page_wraps"]);
		}
		$container->setParameter("tjm_sy_site.wraps", $pageWraps);
		// $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		// $loader->load('services.yml');
	}
}
