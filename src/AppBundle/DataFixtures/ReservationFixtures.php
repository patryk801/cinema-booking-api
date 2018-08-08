<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    private function getRandomName() : string
    {
        $names = [
            'Christopher',
            'Ryan',
            'Ethan',
            'John',
            'Zoey',
            'Sarah',
            'Michelle',
            'Samantha',
        ];

        return $names[mt_rand(0, sizeof($names) - 1)];
    }

    private function getRandomSurname() : string
    {
        $surnames = array(
            'Walker',
            'Thompson',
            'Anderson',
            'Johnson',
            'Tremblay',
            'Peltier',
            'Cunningham',
            'Simpson',
            'Mercado',
            'Sellers'
        );

        return $surnames[mt_rand(0, sizeof($surnames) - 1)];
    }

    private function getRandomEmail() : string
    {
        return uniqid('testemail').'@gmail.com';
    }

    public function load(ObjectManager $manager)
    {
        $screenings = $manager->getRepository('AppBundle:Screening')->findAll();

        foreach ($screenings as $screening)
        {
            for($i = 0; $i < 4; $i++)
            {
                $reservation = new Reservation();
                $reservation
                    ->setScreening($screening)
                    ->setName($this->getRandomName())
                    ->setSurname($this->getRandomSurname())
                    ->setEmail($this->getRandomEmail())
                    ->setCreatedAt(new \DateTime());

                $seats = $screening->getAuditorium()->getSeats();

                $reservation->addSeat($seats[$i+1]);

                $manager->persist($reservation);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ScreeningFixtures::class
        ];
    }
}