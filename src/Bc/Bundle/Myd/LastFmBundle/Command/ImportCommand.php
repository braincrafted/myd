<?php

namespace Bc\Bundle\Myd\LastFmBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bc:myd:lastfm:import')
            ->setDescription('Import data from Last.fm')
            ->addArgument('username', InputArgument::REQUIRED, 'The last.fm username')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()->get('bc_myd_lastfm.import.factory')->getTrackPlayImporter();
        $importer->import(array(
            'user' => $input->getArgument('username')
        ));
    }
}