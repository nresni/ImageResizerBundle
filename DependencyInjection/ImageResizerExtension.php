<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * ImageResizerExtension.
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class ImageResizerExtension extends Extension
{
    /**
     * Loads the AssetOptimizer configuration.
     *
     * @param array            $config    An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function configLoad($config, ContainerBuilder $container)
    {
        if (!$container->hasDefinition('imageresizer')) {
            $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
            $loader->load('imageresizer.xml');
        }

        if (isset($config['sizes'])) {
            $container->setParameter('imageresizer.sizes', $config['sizes']);
        }

        if (isset($config['functions'])) {
            $container->setParameter('imageresizer.functions', $config['functions']);
        }

        if (isset($config['base_directory'])) {
            $container->setParameter('imageresizer.loader.base_directory', $config['base_directory']);
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    /**
     *
     * Enter description here ...
     */
    public function getNamespace()
    {
        return null;
    }

    /**
     *
     * Enter description here ...
     */
    public function getAlias()
    {
        return 'imageresizer';
    }
}