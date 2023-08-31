<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230831103425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add vendor and vendor_setting tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE vendor (id VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vendor_setting (id INT NOT NULL, user_id INT NOT NULL, vendor_id VARCHAR(255) NOT NULL, setting JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_810380F7A76ED395 ON vendor_setting (user_id)');
        $this->addSql('CREATE INDEX IDX_810380F7F603EE73 ON vendor_setting (vendor_id)');
        $this->addSql('COMMENT ON COLUMN vendor_setting.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN vendor_setting.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE vendor_setting ADD CONSTRAINT FK_810380F7A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vendor_setting ADD CONSTRAINT FK_810380F7F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vendor_setting DROP CONSTRAINT FK_810380F7A76ED395');
        $this->addSql('ALTER TABLE vendor_setting DROP CONSTRAINT FK_810380F7F603EE73');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE vendor_setting');
    }
}
