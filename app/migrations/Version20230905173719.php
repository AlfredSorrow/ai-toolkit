<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230905173719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add type column to model table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model ADD type VARCHAR(255) DEFAULT \'unknown\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model DROP type');
    }
}
