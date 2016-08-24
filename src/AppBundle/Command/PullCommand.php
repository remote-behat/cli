<?php

namespace AppBundle\Command;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class PullCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pull')
            ->setDescription('Pulls features from server')
            ->setHelp('Use rbehat pull to retrieve features from the server');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();

        $finder->name('rbehat.yml')->in('.')->files()->depth(0);

        if (!$finder->count()) {
            throw new \Exception('Could not find rbehat.yml');
        }

        $conf = Yaml::parse(file_get_contents('rbehat.yml'));

        $client = new Client();
        $client->get($conf['server']['hostname'] . '/project/' . $conf['project']);

        $output->writeln('Will pull, someday');
    }
}
