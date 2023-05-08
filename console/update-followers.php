<?php // console/update-followers.php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$applicationClient = new \App\Http\SymfonyHttpApplicationClient($httpClient);
$twitterClient = new \App\Http\TwitterClient($applicationClient);

$command = new \App\Command\UpdateFollowersCommand(
    $entityManager,
    $twitterClient,
    [19057969, 1285294171033604101]
);

$command->execute();