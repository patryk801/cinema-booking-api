<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    const GENRES_NAMES = [
        'komedia',
        'komedia romantyczna',
        'akcja',
        'sensacyjny',
        'horror',
        'animowany',
        'fantasy',
        'familijny'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::GENRES_NAMES as $genreName)
        {
            $genre = new Genre();
            $genre->setName($genreName);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}