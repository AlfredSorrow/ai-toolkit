<?php

declare(strict_types=1);

namespace App\Migration;

use App\Encryption\Crypto;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

abstract class AppSettingMigration extends AbstractMigration
{
    abstract protected function getSettingId(): string;

    protected function getSettingValue(): string
    {
        return '';
    }

    protected function getSettingDescription(): string
    {
        return '';
    }

    final public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO app_setting (id, value, created_at, updated_at, description) VALUES (?, ?, NOW(), NOW(), ?)', [
            $this->getSettingId(),
            Crypto::encrypt($this->getSettingValue()),
            $this->getSettingDescription(),
        ]);
    }

    final public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM app_setting WHERE id = ?', [$this->getSettingId()]);
    }
}
