<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Faker\FakerFixtureTrait;
use App\Entity\Subscription;

class SubscriptionFixtures extends Fixture
{
    use FakerFixtureTrait;

    public function load(ObjectManager $manager): void
    {
        $basePrice = 0;
        $baseMonths = 2;
        for ($i = 0; $i < 5; ++$i) {
            $category = (new Subscription())
                ->setName($this->faker->word())
                ->setPrice($basePrice += 10)
                ->setDurationInMonths($baseMonths += 2);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
