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
            $this->loadDefaults($container);
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

        $this->loadCache($container, isset($config['cache']['class']) ? $config['cache']['class'] : 'memcache');

    }

    /**
     * Load cache
     */
    protected function loadCache(ContainerBuilder $container, $cache)
    {
        $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');

        switch ($cache['class']) {
            case 'memcache':
                $loader->load("cache.memcache.xml");

                if (isset($config['dsn'])) {
                    $container->setParameter('imageresizer.memcache.dsn', $config['dsn']);
                }

                if (isset($config['port'])) {
                  $container->setParameter('imageresizer.memcache.port', $config['port']);
                }
            break;

            case 'mongo':
                $loader->load("cache.mongo.xml");

                if (isset($config['dsn'])) {
                    $container->setParameter('imageresizer.mongo.dsn', $config['dsn']);
                }

                if (isset($config['port'])) {
                  $container->setParameter('imageresizer.mongo.port', $config['port']);
                }

                if (isset($config['database'])) {
                    $container->setParameter('imageresizer.mongo.database', $config['database']);
                }

                if (isset($config['collection'])) {
                  $container->setParameter('imageresizer.mongo.collection', $config['collection']);
                }
            break;

            default:
                throw new InvalidArgumentException("unsupported file cache : ".$cache);
        }
    }

    /**
     * Load defaults
     */
    protected function loadDefaults(ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');

        $loader->load('imageresizer.xml');
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