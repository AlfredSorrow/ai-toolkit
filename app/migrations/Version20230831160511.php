<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230831160511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add model table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, vendor_id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D9F603EE73 ON model (vendor_id)');
        $this->addSql('COMMENT ON COLUMN model.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN model.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D9F603EE73');
        $this->addSql('DROP TABLE model');
    }
}
