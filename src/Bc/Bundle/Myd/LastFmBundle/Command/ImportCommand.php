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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getContainer()->get('bc_lastfm.client');

        $command = $client->getCommand('user.getRecentTracks', array(
            'user'      => 'feredir',
            'format'    => 'json'
        ));
        $responseModel = $client->execute($command);
        print_r($responseModel);
    }
}