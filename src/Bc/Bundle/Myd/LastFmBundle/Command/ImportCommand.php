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
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Number of tracks to import')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()->get('bc_myd_lastfm.import.factory')->getTrackPlayImporter();
        $importer->setImportCallback(function ($message, $context) use ($input, $output) {
            $output->writeln(sprintf('Imported %d of %d pages.', $context['page'], $context['totalPages']));
        });

        $importer->import(
            array('user' => $input->getArgument('username')),
            $input->getOption('limit')
        );
    }
}
