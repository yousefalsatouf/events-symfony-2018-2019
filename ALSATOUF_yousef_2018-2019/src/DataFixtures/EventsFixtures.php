<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EventsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        //create 3 fake categories
        for ($c=1; $c<=3; $c++)
        {
            $cat = new Category();
            $cat->setName($faker->sentence(1))
                ->setDescription($faker->paragraph());

            $manager->persist($cat);

            //now create between 3 and 6 articles ...
            for ($a=1; $a<=mt_rand(4, 6); $a++)
            {
                $event = new Event();

                $content = '<p>'.join($faker->paragraphs(3), '</p><p>').'</p>';
                $now = new \DateTime();

                $event->setName($faker->name)
                    ->setDescription($content)
                    ->setPlace($faker->city)
                    ->setStart($faker->dateTimeBetween('-6 months'))
                    ->setEnd($faker->dateTimeBetween($now))
                    ->setCategory($cat);

                $manager->persist($event);

                // create the username ...
                for ($m=1; $m<=5; $m++)
                {
                    $user = new User();

                    $user->setUsername($faker->name)
                        ->setProfilePic($faker->imageUrl($width = 250, $height = 250))
                        ->addEvent($event);

                    $manager->persist($user);
                }
            }
        }

        $manager->flush();
    }
}
