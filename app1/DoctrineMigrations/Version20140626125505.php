<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140626125505 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE call_reporting (id INT AUTO_INCREMENT NOT NULL, contact INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, startsAt DATETIME NOT NULL, finishesAt DATETIME NOT NULL, status INT NOT NULL, INDEX IDX_969EC66C4C62E638 (contact), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE call_reporting ADD CONSTRAINT FK_969EC66C4C62E638 FOREIGN KEY (contact) REFERENCES contact_card (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE call_reporting");
    }
}
