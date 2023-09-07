<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230907164558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add model_profile table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE model_profile (id INT NOT NULL, user_id INT NOT NULL, model_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, setting JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E1C4C3FEA76ED395 ON model_profile (user_id)');
        $this->addSql('CREATE INDEX IDX_E1C4C3FE7975B7E7 ON model_profile (model_id)');
        $this->addSql('COMMENT ON COLUMN model_profile.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN model_profile.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE model_profile ADD CONSTRAINT FK_E1C4C3FEA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE model_profile ADD CONSTRAINT FK_E1C4C3FE7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model_profile DROP CONSTRAINT FK_E1C4C3FEA76ED395');
        $this->addSql('ALTER TABLE model_profile DROP CONSTRAINT FK_E1C4C3FE7975B7E7');
        $this->addSql('DROP TABLE model_profile');
    }
}
