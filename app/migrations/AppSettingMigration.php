<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

abstract class AppSettingMigration extends AbstractMigration
{
    abstract protected function getSettingId(): string;

    protected function getSettingValue(): string
    {
        return '';
    }

    final public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO app_setting (id, value, created_at, updated_at) VALUES (?, ?, NOW(), NOW())', [
            $this->getSettingId(),
            json_encode($this->getSettingValue()),
        ]);
    }

    final public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM app_setting WHERE id = ?', [$this->getSettingId()]);
    }
}
