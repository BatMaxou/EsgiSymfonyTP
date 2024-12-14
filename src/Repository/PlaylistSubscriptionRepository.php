<?php

namespace App\Repository;

use App\Entity\PlaylistSubscription;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlaylistSubscription>
 */
class PlaylistSubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistSubscription::class);
    }

    /**
     * @return Collection<PlaylistSubscription>
     */
    public function findAllByUser(User $user): array
    {
        return $this->createQueryBuilder('ps')
            ->andWhere('ps.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
