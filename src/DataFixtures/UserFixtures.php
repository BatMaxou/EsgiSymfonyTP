<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Playlist;
use App\Entity\WatchHistory;
use App\Entity\PlaylistMedia;
use App\Enum\AccountStatusEnum;
use App\Entity\SubscriptionHistory;
use App\Repository\MediaRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\SubscriptionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Faker\FakerFixtureTrait;
use App\Enum\CommentStatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerFixtureTrait {
        __construct as initializeFaker;
    }

    private ObjectManager $manager;

    public function __construct(
        private readonly SubscriptionRepository $subscriptionRepository,
        private readonly MediaRepository $mediaRepository,
    ) {
        $this->initializeFaker();
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $subscriptionIds = $this->subscriptionRepository->findAll(['id']);
        $mediaIds = $this->mediaRepository->findAll(['id']);

        for ($i = 0; $i < 100; ++$i) {
            $user = $this->createUser($subscriptionIds);

            $this->createSubscriptionHistory($user, $subscriptionIds);
            $this->createPlaylists($user, $mediaIds);
            $this->createWatchHistory($user, $mediaIds);
            $this->createComments($user, $mediaIds);

            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SubscriptionFixtures::class,
            MediaFixtures::class,
        ];
    }

    /**
     * @param int[] $subscriptionIds
     */
    private function createUser(array $subscriptionIds): User
    {
        return (new User())
            ->setEmail($this->faker->email())
            ->setPassword($this->faker->password())
            ->setUsername($this->faker->userName())
            ->setAccountStatus($this->faker->randomElement(AccountStatusEnum::cases()))
            ->setCurrentSubscription($this->subscriptionRepository->find($this->faker->randomElement($subscriptionIds)));
    }

    /**
     * @param int[] $subscriptionIds
     */
    private function createSubscriptionHistory(User $user, array $subscriptionIds): User
    {
        for ($i = 1; $i < $this->faker->numberBetween(2, 5); ++$i) {
            $subscription = $this->subscriptionRepository->find($this->faker->randomElement($subscriptionIds));
            $startDate = new \DateTimeImmutable($this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'));
            $endDate = $startDate->modify('+'.$subscription->getDurationInMonths().' months');

            $subscriptionHistory = (new SubscriptionHistory())
                ->setUser($user)
                ->setSubscription($subscription)
                ->setStartDate($startDate)
                ->setEndDate($endDate)
            ;

            $this->manager->persist($subscriptionHistory);

            $user->addSubscriptionHistory($subscriptionHistory);
        }

        return $user;
    }

    /**
     * @param int[] $mediaIds
     */
    private function createPlaylists(User $user, array $mediaIds): User
    {
        for ($i = 0; $i < $this->faker->numberBetween(0, 5); ++$i) {
            $createdAt = new \DateTimeImmutable($this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'));

            $playlist = (new Playlist())
                ->setName($this->faker->word())
                ->setUser($user)
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($createdAt)
            ;

            $this->manager->persist($playlist);

            $user->addPlaylist($playlist);
        }

        return $user;
    }

    /**
     * @param int[] $mediaIds
     */
    private function createPlaylistMedia(Playlist $playlist, array $mediaIds): Playlist
    {
        for ($i = 0; $i < $this->faker->numberBetween(1, 5); ++$i) {
            $playlistMedia = (new PlaylistMedia())
                ->setPlaylist($playlist)
                ->setMedia($this->mediaRepository->find($this->faker->randomElement($mediaIds)))
                ->setAddedAt(new \DateTimeImmutable($this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')));

            $this->manager->persist($playlistMedia);

            $playlist->addPlaylistMedia($playlistMedia);
        }

        return $playlist;
    }

    /**
     * @param int[] $mediaIds
     */
    private function createWatchHistory(User $user, array $mediaIds): User
    {
        for ($i = 0; $i < $this->faker->numberBetween(0, 20); ++$i) {
            $watchHistory = (new WatchHistory())
                ->setUser($user)
                ->setMedia($this->mediaRepository->find($this->faker->randomElement($mediaIds)))
                ->setLastWatched(new \DateTimeImmutable($this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')))
                ->setNumberOfViews($this->faker->numberBetween(1, 10))
            ;

            $this->manager->persist($watchHistory);

            $user->addWatchHistory($watchHistory);
        }

        return $user;
    }

    /**
     * @param int[] $mediaIds
     */
    private function createComments(User $user, array $mediaIds): User
    {
        for ($i = 0; $i < $this->faker->numberBetween(0, 20); ++$i) {
            $comment = (new Comment())
                ->setPublisher($user)
                ->setMedia($this->mediaRepository->find($this->faker->randomElement($mediaIds)))
                ->setStatus($this->faker->randomElement(CommentStatusEnum::cases()))
                ->setContent($this->faker->paragraph())
            ;

            $this->manager->persist($comment);

            $user->addComment($comment);
        }

        return $user;
    }
}
