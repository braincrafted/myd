<?php

namespace Bc\Bundle\Myd\LastFmBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    /** @var \Symfony\Component\Console\Helper\ProgressHelper */
    private $progress;

    protected function configure()
    {
        $this
            ->setName('bc:myd:lastfm:import')
            ->setDescription('Import data from Last.fm')
            ->addArgument('username', InputArgument::REQUIRED, 'The last.fm username')
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Number of tracks to import')
            ->addOption('from', 'f', InputOption::VALUE_REQUIRED, 'Date range start')
            ->addOption('to', 't', InputOption::VALUE_REQUIRED, 'Date range end')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output   = $output;
        $this->input    = $input;

        $importer = $this->getContainer()->get('bc_myd_lastfm.import.factory')->getTrackPlayImporter();
        $importer->setImportCallback(array($this, 'importCallback'));

        $importer->import(
            array(
                'user' => $input->getArgument('username'),
                'from'  => $input->getOption('from') ? strtotime($input->getOption('from')) : null,
                'to'    => $input->getOption('to') ? strtotime($input->getOption('to')) : null
            ),
            $input->getOption('limit')
        );

        $this->progress->finish();
    }

    public function importCallback($message, $context)
    {
        if (!$this->progress) {
            $totalPages = $this->input->getOption('limit') ? ceil($this->input->getOption('limit') / $context['perPage']) : $context['totalPages'];

            $this->progress = $this->getHelperSet()->get('progress');
            $this->progress->start($this->output, $totalPages);
        }

        $this->progress->advance();
        // $this->output->writeln(sprintf('Fetched page %d of %d total pages.', $context['page'], $context['totalPages']));
    }
}
