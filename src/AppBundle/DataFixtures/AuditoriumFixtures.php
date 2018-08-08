<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Auditorium;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuditoriumFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $auditoriumA = new Auditorium();
        $auditoriumA->setName('A');

        $auditoriumB = new Auditorium();
        $auditoriumB->setName('B');

        $auditoriumC = new Auditorium();
        $auditoriumC->setName('C');

        $auditoriumD = new Auditorium();
        $auditoriumD->setName('D');

        $auditoriumE = new Auditorium();
        $auditoriumE->setName('E');

        $auditoriumF = new Auditorium();
        $auditoriumF->setName('F');

        $auditoriumG = new Auditorium();
        $auditoriumG->setName('G');

        $auditoriumH = new Auditorium();
        $auditoriumH->setName('H');

        $manager->persist($auditoriumA);
        $manager->persist($auditoriumB);
        $manager->persist($auditoriumC);
        $manager->persist($auditoriumD);
        $manager->persist($auditoriumE);
        $manager->persist($auditoriumF);
        $manager->persist($auditoriumG);
        $manager->persist($auditoriumH);

        $manager->flush();
    }
}