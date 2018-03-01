<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140626143547 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE call_reporting DROP FOREIGN KEY FK_969EC66C4C62E638");
        $this->addSql("ALTER TABLE call_reporting ADD type INT NOT NULL");
        $this->addSql("ALTER TABLE call_reporting ADD CONSTRAINT FK_969EC66C4C62E638 FOREIGN KEY (contact) REFERENCES contact (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE call_reporting DROP FOREIGN KEY FK_969EC66C4C62E638");
        $this->addSql("ALTER TABLE call_reporting DROP type");
        $this->addSql("ALTER TABLE call_reporting ADD CONSTRAINT FK_969EC66C4C62E638 FOREIGN KEY (contact) REFERENCES contact_card (id)");
    }
}
