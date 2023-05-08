<?php // src/Http/ApplicationClientInterface.php

namespace App\Http;

interface ApplicationClientInterface
{
    public function get(string $url): string;
}
