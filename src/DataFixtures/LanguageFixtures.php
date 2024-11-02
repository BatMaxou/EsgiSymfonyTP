<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\FakerFixtureTrait;
use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    use FakerFixtureTrait;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $code = $this->faker->languageCode();
            $language = (new Language())
                ->setName(ucfirst($code.$this->faker->word))
                ->setCode($code);

            $manager->persist($language);
        }
        $manager->flush();
    }
}
