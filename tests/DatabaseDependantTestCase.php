<?php // tests/DatabaseDependantTestCase

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseDependantTestCase extends TestCase
{
    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        require __DIR__ . '/connection.php';
        $this->entityManager = $entityManager;
        SchemaLoader::load($entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
