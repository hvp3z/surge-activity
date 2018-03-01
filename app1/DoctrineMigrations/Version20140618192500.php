<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140618192500 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_card ADD street_address VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(127) DEFAULT NULL, ADD state VARCHAR(4) DEFAULT NULL, ADD zip VARCHAR(6) DEFAULT NULL");
        $this->addSql("ALTER TABLE lead ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD mail_status TINYINT(1) NOT NULL, ADD call_status TINYINT(1) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_card DROP street_address, DROP city, DROP state, DROP zip");
        $this->addSql("ALTER TABLE lead DROP first_name, DROP last_name, DROP mail_status, DROP call_status");
    }
}
