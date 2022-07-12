<?php

namespace App\DataFixtures;

use App\Entity\Faq;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        for($i=0 ;$i<20;$i++) {
            $faq = new Faq();

            $faq->setReponse($faker->text());
            $faq->setQuestion($faker->text(20));
            $manager->persist($faq);

            $manager->flush();
        }

    }
}
