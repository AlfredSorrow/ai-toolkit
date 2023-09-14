<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230907220044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add status to model';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model ADD status VARCHAR(255) DEFAULT \'disabled\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model DROP status');
    }
}
