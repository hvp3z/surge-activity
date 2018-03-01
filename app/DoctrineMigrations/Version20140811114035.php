<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140811114035 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact ADD donot_call INT DEFAULT NULL, ADD donot_email TINYINT(1) DEFAULT NULL");
        $this->addSql("ALTER TABLE contact_card ADD middle_initial VARCHAR(8) DEFAULT NULL");
        $this->addSql("ALTER TABLE lead DROP mail_status, DROP call_status");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact DROP donot_call, DROP donot_email");
        $this->addSql("ALTER TABLE contact_card DROP middle_initial");
        $this->addSql("ALTER TABLE lead ADD mail_status TINYINT(1) NOT NULL, ADD call_status INT NOT NULL");
    }
}
