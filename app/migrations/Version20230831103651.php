<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230831103651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add openai vendor';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO vendor (id, description) VALUES ('openai', '')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM vendor WHERE id = 'openai'");
    }
}
