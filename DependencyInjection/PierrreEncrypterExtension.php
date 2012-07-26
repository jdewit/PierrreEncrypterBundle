<?php

namespace Pierrre\EncrypterBundle\DependencyInjection;

use Pierrre\EncrypterBundle\Util\Encrypter;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PierrreEncrypterExtension extends Extension implements ConfigurationInterface{
	/**
	 * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
	 */
	public function load(array $configs, ContainerBuilder $container){
		//Load config
		$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');

		$config = $this->processConfiguration($this, $configs);
		$alias = $this->getAlias();

		//Default keys
		$kernelSecret = $container->getParameter('kernel.secret');
		foreach($config['encrypters'] as $name => $encrypter){
			if(!isset($encrypter['key'])){
				$config['encrypters'][$name]['key'] = $kernelSecret;
			}
		}

		//Set encrypters parameters
		$container->setParameter($alias . '.encrypters', $config['encrypters']);

		//Twig extension
		$twig = $config['twig'];
		if($twig['enabled']){
			$twigDefaultEncrypter = $twig['default_encrypter'];

			if($twigDefaultEncrypter == null){
				$encrypterNames = array_keys($config['encrypters']);
				$twigDefaultEncrypter = $encrypterNames[0];
			}

			$container->setParameter($alias . '.twig.default_encrypter', $twigDefaultEncrypter);

			$loader->load('twig_extension.yml');
		}

		//Form transformer
		$form = $config['form'];
		if($form['enabled']){
			$formDefaultEncrypter = $form['default_encrypter'];

			if($formDefaultEncrypter == null){
				$encrypterNames = array_keys($config['encrypters']);
				$formDefaultEncrypter = $encrypterNames[0];
			}

			$container->setParameter($alias . '.form.default_encrypter', $formDefaultEncrypter);

			$loader->load('form.yml');
		}

	}

	/**
	 * @see Symfony\Component\Config\Definition.ConfigurationInterface::getConfigTreeBuilder()
	 */
	public function getConfigTreeBuilder(){
		$treeBuilder = new TreeBuilder();

		$treeBuilder->root($this->getAlias())
			->children()
				->arrayNode('encrypters')
					->isRequired()
					->requiresAtLeastOneElement()
					->useAttributeAsKey('name')
					->prototype('array')
						->children()
							->scalarNode('key')->end()
							->scalarNode('algorithm')->end()
							->scalarNode('mode')->end()
							->scalarNode('random_initialization_vector')->end()
							->scalarNode('base64')->end()
							->scalarNode('base64_url_safe')->end()
						->end()
					->end()
				->end()
				->arrayNode('twig')
					->addDefaultsIfNotSet()
					->children()
						->scalarNode('enabled')->defaultFalse()->end()
				        ->scalarNode('default_encrypter')->defaultNull()->end()
					->end()
				->end()
				->arrayNode('form')
					->addDefaultsIfNotSet()
					->children()
						->scalarNode('enabled')->defaultFalse()->end()
				        ->scalarNode('default_encrypter')->defaultNull()->end()
					->end()
				->end()

			->end()
		;

		return $treeBuilder;
	}
}
