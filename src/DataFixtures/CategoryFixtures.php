<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\FakerFixtureTrait;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    use FakerFixtureTrait;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $word = $this->faker->word();
            $category = (new Category())
                ->setName($word)
                ->setLabel(ucfirst($word));

            $manager->persist($category);
        }
        $manager->flush();
    }
}
