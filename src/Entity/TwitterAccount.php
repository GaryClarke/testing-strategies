<?php // src/Entity/TwitterAccount.php (version 2 updated May 2023)

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TwitterAccountRepository;

#[ORM\Entity(repositoryClass: TwitterAccountRepository::class)]
#[ORM\Table(name: "twitter_account")]
class TwitterAccount
{
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: "twitter_account_id", type: "bigint")]
    private int $twitterAccountId;

    #[ORM\Column(name: "username", type: "string")]
    private string $username;

    #[ORM\Column(name: "follower_count", type: "integer", nullable: true)]
    private ?int $followerCount;

    #[ORM\Column(name: "following_count", type: "integer", nullable: true)]
    private ?int $followingCount;

    #[ORM\Column(name: "followers_per_week", type: "integer", nullable: true)]
    private ?int $followersPerWeek;

    #[ORM\Column(name: "tweet_count", type: "integer", nullable: true)]
    private ?int $tweetCount;

    #[ORM\Column(name: "listed_count", type: "integer", nullable: true)]
    private ?int $listedCount;

    #[ORM\Column(name: "created_at", type: "datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTwitterAccountId(): int
    {
        return $this->twitterAccountId;
    }

    public function setTwitterAccountId(int $twitterAccountId): void
    {
        $this->twitterAccountId = $twitterAccountId;
    }

    public function getFollowerCount(): ?int
    {
        return $this->followerCount;
    }

    public function setFollowerCount(?int $followerCount): void
    {
        $this->followerCount = $followerCount;
    }

    public function getFollowersPerWeek(): ?int
    {
        return $this->followersPerWeek;
    }

    public function setFollowersPerWeek(?int $followersPerWeek): void
    {
        $this->followersPerWeek = $followersPerWeek;
    }

    public function getCreatedAt(): \DateTimeImmutable|\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getFollowingCount(): ?int
    {
        return $this->followingCount;
    }

    public function setFollowingCount(?int $followingCount): void
    {
        $this->followingCount = $followingCount;
    }

    public function getTweetCount(): ?int
    {
        return $this->tweetCount;
    }

    public function setTweetCount(?int $tweetCount): void
    {
        $this->tweetCount = $tweetCount;
    }

    public function getListedCount(): ?int
    {
        return $this->listedCount;
    }

    public function setListedCount(?int $listedCount): void
    {
        $this->listedCount = $listedCount;
    }

    public function setCreatedAt(\DateTimeImmutable|\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
