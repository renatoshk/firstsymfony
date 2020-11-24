<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
           $this->passwordEncoder = $passwordEncoder;
    }
    protected function loadData(ObjectManager $manager)
    {
//        $this->createMany(User::class,1, function (User $user){
//                $user->setEmail(sprintf('shkulaku%d@gmail.com', 1));
//                $user->setFirstName($this->faker->firstName);
//                $user->setPassword($this->passwordEncoder->encodePassword(
//                             $user,
//                'engage'
//            ));
//        });
//
//        $manager->flush();

        //FOR admins
        $this->createMany(User::class,1, function (User $user){
            $user->setEmail(sprintf('shkulaku%d@gmail.com', 1));
            $user->setFirstName($this->faker->firstName);
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
        });

        $manager->flush();
    }
}
