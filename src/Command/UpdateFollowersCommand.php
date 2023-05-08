<?php // src/Command/UpdateFollowersCommand.php

namespace App\Command;

use App\Http\TwitterClient;
use App\Entity\TwitterAccount;
use Doctrine\ORM\EntityManagerInterface;

class UpdateFollowersCommand
{
    private array $accountIds;
    private TwitterClient $twitterClient;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        TwitterClient $twitterClient,
        array $accountIds
    )
    {
        $this->entityManager = $entityManager;
        $this->twitterClient = $twitterClient;
        $this->accountIds = $accountIds;
    }

    public function execute(): void
    {
        foreach ($this->accountIds as $accountId) {

            // 1. ping twitter api for user data (TwitterClient::getUserById())
            $user = $this->twitterClient->getUserById($accountId);

            // 2. Calculate number of new followers per week since last check
            $repo = $this->entityManager->getRepository(TwitterAccount::class);

            $newFollowersPerWeek = $repo->newFollowersPerWeek(
                $accountId,
                $user['public_metrics']['followers_count'],
                date_create()
            );

            // 3. Create a new record in DB with updated values
            $twitterAccount = new TwitterAccount();
            $twitterAccount->setTwitterAccountId($accountId);
            $twitterAccount->setUsername($user['username']);
            $twitterAccount->setTweetCount($user['public_metrics']['tweet_count']);
            $twitterAccount->setListedCount($user['public_metrics']['listed_count']);
            $twitterAccount->setFollowingCount($user['public_metrics']['following_count']);
            $twitterAccount->setFollowerCount($user['public_metrics']['followers_count']);
            $twitterAccount->setFollowersPerWeek($newFollowersPerWeek);
            $this->entityManager->persist($twitterAccount);
        }

        $this->entityManager->flush();

        fwrite(STDOUT, 'Process complete' . PHP_EOL);
    }
}