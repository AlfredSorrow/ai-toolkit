<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230907173211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add name to profile';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model_profile ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model_profile DROP name');
    }
}
