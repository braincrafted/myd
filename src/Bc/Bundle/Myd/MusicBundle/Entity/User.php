<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Bc\Bundle\Myd\MusicBundle\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="music_user")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="account_type", type="string")
 * @ORM\DiscriminatorMap({
 *     "lastfm" = "Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser"
 * })
 */
abstract class User implements UserInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
