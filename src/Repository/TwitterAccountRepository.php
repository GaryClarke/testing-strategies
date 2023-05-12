<?php // src/Repository/TwitterAccountRepository.php

namespace App\Repository;

use App\Utility\DateHelper;
use App\Entity\TwitterAccount;
use Doctrine\ORM\EntityRepository;

class TwitterAccountRepository extends EntityRepository
{
    public function lastRecord(int $accountId): ?TwitterAccount
    {
        $query = $this->createQueryBuilder('ta')
            ->andWhere('ta.twitterAccountId = :accountId')
            ->orderBy('ta.createdAt', 'DESC')
            ->setParameter('accountId', $accountId)
            ->setMaxResults(1)
            ->getQuery();

        // What should happen if null?
        return $query->getOneOrNullResult();
    }
}