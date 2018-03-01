<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140917104839 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE lead_event_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE lead_event ADD type INT DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_event ADD CONSTRAINT FK_5D49C7288CDE5729 FOREIGN KEY (type) REFERENCES LeadEventType (id)");
        $this->addSql("CREATE INDEX IDX_5D49C7288CDE5729 ON lead_event (type)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_event DROP FOREIGN KEY FK_5D49C7288CDE5729");
        $this->addSql("DROP TABLE lead_event_type");
        $this->addSql("DROP INDEX IDX_5D49C7288CDE5729 ON lead_event");
        $this->addSql("ALTER TABLE lead_event DROP type");
    }
}
