<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

class FixPostgresSQLDefaultSchemaListener
{
    /**
     * @throws SchemaException|Exception
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args
            ->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        if (!$schemaManager instanceof PostgreSQLSchemaManager) {
            return;
        }

        $schema = $args->getSchema();

        foreach ($schemaManager->getExistingSchemaSearchPaths() as $namespace) {
            if (!$schema->hasNamespace($namespace)) {
                $schema->createNamespace($namespace);
            }
        }
    }
}
