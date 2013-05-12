<?php

namespace Bc\Bundle\Myd\MusicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RecentTracksController extends Controller
{
    public function recentTracksAction()
    {
        $plays = $this->get('bc_myd_music.track_play_manager')->findTrackPlays(array('playDate' => 'DESC'),5000);

        return $this->render(
            'BcMydMusicBundle:RecentTracks:list.html.twig',
            array(
                'plays' => $plays
            )
        );
    }
}
