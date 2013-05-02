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
        $client = $this->getContainer()->get('bc_last_fm_service.client');

        $command = $client->getCommand('getArtistInfo', array(
            'artist'    => 'Radiohead',
            'api_key'   => '321c12389cc476b92c3a216024b363cd'
        ));
        $responseModel = $client->execute($command);
        print_r($responseModel);
    }
}