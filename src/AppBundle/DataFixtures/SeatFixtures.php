<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Seat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SeatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $auditoriumsRepository = $manager->getRepository('AppBundle:Auditorium');

        $auditoriumA = $auditoriumsRepository->findOneBy(['name' => 'A']);
        $auditoriumB = $auditoriumsRepository->findOneBy(['name' => 'B']);
        $auditoriumC = $auditoriumsRepository->findOneBy(['name' => 'C']);
        $auditoriumD = $auditoriumsRepository->findOneBy(['name' => 'D']);
        $auditoriumE = $auditoriumsRepository->findOneBy(['name' => 'E']);
        $auditoriumF = $auditoriumsRepository->findOneBy(['name' => 'F']);
        $auditoriumG = $auditoriumsRepository->findOneBy(['name' => 'G']);
        $auditoriumH = $auditoriumsRepository->findOneBy(['name' => 'H']);

        /* Seats in auditorium A */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumA)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium B */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumB)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium C */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumC)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium D */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumD)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium E */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumE)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium F */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumF)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium G */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumG)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        /* Seats in auditorium H */
        for($i = 1; $i <= 12; $i++)
        {
            for($j = 1; $j <= 20; $j++)
            {
                $seat = new Seat();
                $seat
                    ->setAuditorium($auditoriumH)
                    ->setRow($i)
                    ->setName($j);

                $manager->persist($seat);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AuditoriumFixtures::class];
    }
}