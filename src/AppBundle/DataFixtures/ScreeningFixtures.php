<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Screening;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ScreeningFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $movies = $manager->getRepository('AppBundle:Movie')->findAll();
        $auditoriums = $manager->getRepository('AppBundle:Auditorium')->findAll();

        foreach ($auditoriums as $auditorium)
        {
            foreach ($movies as $movie)
            {
                $startTime = new \DateTime();
                $endTime = new \DateTime();

                $screening = new Screening();
                $screening
                    ->setAuditorium($auditorium)
                    ->setMovie($movie)
                    ->setStartTime($startTime->add(new \DateInterval('PT1H')))
                    ->setEndTime($endTime->add(new \DateInterval('PT2H30M')));

                $manager->persist($screening);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MovieFixtures::class,
            AuditoriumFixtures::class,
        ];
    }
}