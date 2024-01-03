<?php // src/Command/UpdateFollowersCommand.php

namespace App\Command;

use App\Http\TwitterClient;
use App\Entity\TwitterAccount;
use App\Statistics\TwitterStatisticsCalculator;
use App\Utility\DateHelper;
use Doctrine\ORM\EntityManagerInterface;

readonly class UpdateFollowersCommand
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param TwitterClient $twitterClient
     * @param array<int> $accountIds
     * @param \DateTimeInterface $processDate
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TwitterClient $twitterClient,
        private array $accountIds,
        private \DateTimeInterface $processDate
    ) {
    }

    public function execute(): void
    {
        foreach ($this->accountIds as $accountId) {

            // 1. ping twitter api for user data (TwitterClient::getUserById())
            $user = $this->twitterClient->getUserById($accountId);

            // 2. Calculate number of new followers per week since last check
            $repo = $this->entityManager->getRepository(TwitterAccount::class);
            $lastRecord = $repo->lastRecord($accountId);

            $user['new_followers_per_week'] = (new TwitterStatisticsCalculator(
                new DateHelper()))
                ->newFollowersPerWeek(
                    $lastRecord, $user['followers_count'], $this->processDate
                );

            // 3. Create a new record in DB with updated values
            $repo->addFromArray($user);
        }

        $this->entityManager->flush();
    }
}
