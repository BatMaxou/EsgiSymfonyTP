<?php

namespace App\Repository;

use App\Entity\Media;
use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @return Comment[]
     */
    public function getParentCommentsFor(Media $media): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.media = :media')
            ->andWhere('c.parentComment IS NULL')
            ->setParameter('media', $media)
            ->getQuery()
            ->getResult();
    }
}
