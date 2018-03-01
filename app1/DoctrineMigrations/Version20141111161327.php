<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141111161327 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_subject ADD system_lead_type SMALLINT DEFAULT NULL, CHANGE lead_type lead_type INT DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A20062146D2812F3 FOREIGN KEY (lead_type) REFERENCES lead_type (id)");
        $this->addSql("CREATE INDEX IDX_A20062146D2812F3 ON lead_subject (lead_type)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_subject DROP FOREIGN KEY FK_A20062146D2812F3");
        $this->addSql("DROP INDEX IDX_A20062146D2812F3 ON lead_subject");
        $this->addSql("ALTER TABLE lead_subject DROP system_lead_type, CHANGE lead_type lead_type SMALLINT DEFAULT NULL");
    }
}
