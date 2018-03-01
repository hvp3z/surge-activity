<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141106211852 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE driver_ticket ADD driver INT NOT NULL");
        $this->addSql("ALTER TABLE driver_ticket ADD CONSTRAINT FK_D2FF731B11667CD9 FOREIGN KEY (driver) REFERENCES lead_prequalification_driver (id)");
        $this->addSql("CREATE INDEX IDX_D2FF731B11667CD9 ON driver_ticket (driver)");
        $this->addSql("ALTER TABLE lead_prequalification_driver DROP tickets");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE driver_ticket DROP FOREIGN KEY FK_D2FF731B11667CD9");
        $this->addSql("DROP INDEX IDX_D2FF731B11667CD9 ON driver_ticket");
        $this->addSql("ALTER TABLE driver_ticket DROP driver");
        $this->addSql("ALTER TABLE lead_prequalification_driver ADD tickets INT DEFAULT NULL");
    }
}
