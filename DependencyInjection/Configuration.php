<?php
namespace TJM\Bundle\BaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface{
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder(){
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('tjm_base');
		$rootNode
			->children()
				->arrayNode('page_skeletons')
//-! must be 2.1 thing				->setInfo('set templates for renderPage')
					->addDefaultsIfNotSet()
					->useAttributeAsKey("node")
					->beforeNormalization()
						->ifTrue(function($value){ return !is_array($value); })
						->then(function($value){ return Array($value); })
					->end()
					->prototype('scalar')->end()
				->end()
			->end()
		;
		return $treeBuilder;
	}
}

