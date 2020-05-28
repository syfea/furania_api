<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($c = 0; $c < 50; $c++) {
            $user = new User();
            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setEmail($faker->email())
                ->setUsername($faker->userName)
                ->setPassword($hash);
            $manager->persist($user);

            for($i = 0; $i < mt_rand(3,10); $i++) {
                $photo = new Photo();
                $photo->setContent(base64_encode($faker->imageUrl(640, 480)))
                    ->setName($faker->name)
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setUser($user);
                $manager->persist($photo);
            }
        }
        $manager->flush();
    }
}
