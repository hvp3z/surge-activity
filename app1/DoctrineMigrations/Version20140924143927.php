<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140924143927 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_event CHANGE happens_at happens_at DATETIME DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE goal goal VARCHAR(255) DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_auto CHANGE year year INT DEFAULT NULL, CHANGE make make VARCHAR(255) DEFAULT NULL, CHANGE model model VARCHAR(255) DEFAULT NULL, CHANGE vin_number vin_number VARCHAR(255) DEFAULT NULL, CHANGE date_purchased date_purchased DATETIME DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_driver CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE dob dob VARCHAR(255) DEFAULT NULL, CHANGE license license VARCHAR(255) DEFAULT NULL, CHANGE ageLicensed ageLicensed INT DEFAULT NULL, CHANGE tickets tickets VARCHAR(255) DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address CHANGE home home VARCHAR(255) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE state state VARCHAR(255) DEFAULT NULL, CHANGE zipCode zipCode VARCHAR(255) DEFAULT NULL, CHANGE tickets tickets VARCHAR(255) DEFAULT NULL, CHANGE type type SMALLINT DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_event CHANGE happens_at happens_at DATETIME NOT NULL, CHANGE location location VARCHAR(255) NOT NULL, CHANGE goal goal VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_auto CHANGE year year INT NOT NULL, CHANGE make make VARCHAR(255) NOT NULL, CHANGE model model VARCHAR(255) NOT NULL, CHANGE vin_number vin_number VARCHAR(255) NOT NULL, CHANGE date_purchased date_purchased DATETIME NOT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_driver CHANGE name name VARCHAR(255) NOT NULL, CHANGE dob dob VARCHAR(255) NOT NULL, CHANGE license license VARCHAR(255) NOT NULL, CHANGE ageLicensed ageLicensed INT NOT NULL, CHANGE tickets tickets VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address CHANGE type type SMALLINT NOT NULL, CHANGE home home VARCHAR(255) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE state state VARCHAR(255) NOT NULL, CHANGE zipCode zipCode VARCHAR(255) NOT NULL, CHANGE tickets tickets VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(255) NOT NULL");
    }
}
