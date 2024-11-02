<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker\FakerFixtureTrait;
use App\Entity\Episode;
use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Season;
use App\Entity\Serie;
use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerFixtureTrait {
        __construct as initializeFaker;
    }

    private ObjectManager $manager;

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly LanguageRepository $languageRepository,
    ) {
        $this->initializeFaker();
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $categoryIds = $this->categoryRepository->findAll(['id']);
        $languageIds = $this->languageRepository->findAll(['id']);

        for ($i = 0; $i < 100; ++$i) {
            $media = $this->faker->boolean()
                ? $this->createMovie()
                : $this->createSerie()
            ;

            for ($j = 0; $j < $this->faker->numberBetween(1, 3); ++$j) {
                $media->addCategory($this->categoryRepository->find($this->faker->randomElement($categoryIds)));
            }

            for ($j = 0; $j < $this->faker->numberBetween(1, 3); ++$j) {
                $media->addLanguage($this->languageRepository->find($this->faker->randomElement($languageIds)));
            }

            $manager->persist($media);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LanguageFixtures::class,
            CategoryFixtures::class,
        ];
    }

    private function createMovie(): Media
    {
        return $this->initializeMedia(new Movie());
    }

    private function createSerie(): Media
    {
        return $this->createSeasons($this->initializeMedia(new Serie()));
    }

    private function initializeMedia(Media $media): Media
    {
        $cating = $staff = [];

        for ($i = 0; $i < $this->faker->numberBetween(1, 5); ++$i) {
            $cating[] = $this->faker->name();
        }

        for ($i = 0; $i < $this->faker->numberBetween(1, 5); ++$i) {
            $staff[] = $this->faker->name();
        }

        return $media
            ->setCasting($cating)
            ->setCoverImage($this->faker->imageUrl())
            ->setLongDescription($this->faker->paragraph())
            ->setReleaseDate(new \DateTimeImmutable($this->faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d H:i:s')))
            ->setShortDescription($this->faker->sentence())
            ->setStaff($staff)
            ->setTitle($this->faker->word())
        ;
    }

    private function createSeasons(Serie $serie): Serie
    {
        for ($i = 1; $i < $this->faker->numberBetween(2, 5); ++$i) {
            $season = (new Season())
                ->setSerie($serie)
                ->setSeasonNumber($i)
            ;

            $this->manager->persist($season);

            $serie->addSeason($this->createEpisodes($season));
        }

        return $serie;
    }

    private function createEpisodes(Season $season): Season
    {
        for ($i = 1; $i < $this->faker->numberBetween(5, 10); ++$i) {
            $episode = (new Episode())
                ->setSeason($season)
                ->setDuration($this->faker->numberBetween(10, 120))
                ->setReleaseDate(new \DateTimeImmutable($this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')))
                ->setTitle($this->faker->word())
            ;

            $this->manager->persist($episode);

            $season->addEpisode($episode);
        }

        return $season;
    }
}
