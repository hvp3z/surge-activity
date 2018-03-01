<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141020212506 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_prequalification_auto DROP date_purchased, DROP name");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address ADD previous_carrier_name VARCHAR(255) DEFAULT NULL, ADD previous_carrier_police VARCHAR(255) DEFAULT NULL, ADD previous_carrier_x_date DATETIME NOT NULL, DROP name, DROP previous_carrier");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_prequalification_auto ADD date_purchased DATETIME DEFAULT NULL, ADD name VARCHAR(255) DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address ADD name VARCHAR(255) DEFAULT NULL, ADD previous_carrier VARCHAR(255) DEFAULT NULL, DROP previous_carrier_name, DROP previous_carrier_police, DROP previous_carrier_x_date");
    }
}
