<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Finder\Finder;

class InitCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Creates the rbehat.yml file')
            ->setHelp('Initializes rbehat for this project by creating a rbehat.yml file, adapted for your project');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();

        $finder->name('rbehat.yml')->in('.')->files()->depth(0);

        if ($finder->count()) {
            throw new \Exception('rbehat.yml file already exists.');
        }

        $helper = $this->getHelper('question');

        $hostQ = new Question('Hostname ? ');
        $host = $helper->ask($input, $output, $hostQ);

        $projectNameQ = new Question('Remote project name ? ');
        $projectName = $helper->ask($input, $output, $projectNameQ);

        file_put_contents('rbehat.yml', <<<RBH
server:
    hostname: $host

project: projectName
RBH
);

        $output->writeln('You\'re all set. A rbehat.yml file has been created');
    }
}
