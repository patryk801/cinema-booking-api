<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('patryk');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'pass'));
        $user1->setRoles([User::ROLE_ADMIN]);

        $user2 = new User();
        $user2->setUsername('user');
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'pass'));
        $user2->setRoles([User::ROlE_USER]);

        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();
    }
}