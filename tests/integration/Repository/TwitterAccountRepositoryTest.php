<?php // tests/integration/Repository/TwitterAccountRepositoryTest.php

namespace App\Tests\integration\Repository;

use App\Entity\TwitterAccount;
use App\Repository\TwitterAccountRepository;
use App\Tests\DatabaseDependantTestCase;

class TwitterAccountRepositoryTest extends DatabaseDependantTestCase
{
    private TwitterAccountRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->entityManager->getRepository(TwitterAccount::class);
    }

    /** @test */
    public function lastRecord_returns_the_correct_TwitterAccount_entity(): void
    {
        // Setup
        $accountId = 99999;
        $previousAccount = new TwitterAccount();
        $previousAccount->setTwitterAccountId($accountId);
        $previousAccount->setUsername('phpunit');
        $previousAccount->setFollowerCount(1000);
        $previousAccount->setCreatedAt(date_create_immutable('2021-01-01'));
        $this->entityManager->persist($previousAccount);

        $currentAccount = new TwitterAccount();
        $currentAccount->setTwitterAccountId($accountId);
        $currentAccount->setUsername('phpunit');
        $currentAccount->setFollowerCount(1000);
        $currentAccount->setCreatedAt(date_create_immutable('2022-01-01'));
        $this->entityManager->persist($currentAccount);
        $this->entityManager->flush();

        // Do Something
        $lastRecord = $this->repository->lastRecord($accountId);

        // Make Assertions
        $this->assertInstanceOf(TwitterAccount::class, $lastRecord);
        $this->assertSame($lastRecord->getId(), $currentAccount->getId());
        $this->assertSame(2, $lastRecord->getId());
    }

    /** @test */
    public function lastRecord_returns_null_when_no_records_found(): void
    {
        // Setup
        $accountId = 99999;

        // Do Something
        $lastRecord = $this->repository->lastRecord($accountId);

        // Make assertions
        $this->assertNull($lastRecord);
    }
}