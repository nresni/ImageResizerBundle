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