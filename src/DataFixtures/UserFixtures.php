<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Création d'un nouvel utilisateur dans notre bdd (avec le mot de passe 'demo' crypté)
        $user = new User();
        $user->setUsername('demo');
        $user->setPassword($this->encoder->encodePassword($user, 'demo'));
        $manager->persist($user);
        $manager->flush();
    }
}
