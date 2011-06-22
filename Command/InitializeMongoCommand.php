<?php

namespace Adenclassifieds\ImageResizerBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Util\Filesystem;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * AssetsClearCacheCommand.
 *
 * @author David Stendardi <david.stendardi@gmail.com>
 */
class InitializeMongoCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('imageresizer:initialize:mongo');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mongo = $this->container->get('imageresizer.mongo.connection');

        $database = $this->container->getParameter('imageresizer.mongo.connection.database');

        $collection = $this->container->getParameter('imageresizer.mongo.connection.collection');

        $collection = $mongo->selectCollection($database, $collection);

        $test = $collection->ensureIndex(array('key'), array('dropDups' => true, 'unique' => true));

        $output->writeln(sprintf('A new mongo db <info>%s</info> was created with a collection <info>%s</info>', $database, $collection));
    }
}
