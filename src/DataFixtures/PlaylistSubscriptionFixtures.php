<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Faker\FakerFixtureTrait;
use App\Entity\PlaylistSubscription;
use App\Repository\PlaylistRepository;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PlaylistSubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerFixtureTrait {
        __construct as initializeFaker;
    }

    private ObjectManager $manager;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PlaylistRepository $playlistRepository,
    ) {
        $this->initializeFaker();
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $playlistIds = $this->playlistRepository->findAll(['id']);
        $userIds = $this->userRepository->findAll(['id']);

        for ($i = 0; $i < 100; ++$i) {
            $playlistSubscription = (new PlaylistSubscription())
                ->setPlaylist($this->playlistRepository->find($this->faker->randomElement($playlistIds)))
                ->setUser($this->userRepository->find($this->faker->randomElement($userIds)))
                ->setSubscribedAt(new \DateTimeImmutable($this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')))
            ;

            $manager->persist($playlistSubscription);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
