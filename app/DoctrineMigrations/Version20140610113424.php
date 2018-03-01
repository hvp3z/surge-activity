<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140610113424 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Scoring ADD parent_id INT DEFAULT NULL, DROP parent");
        $this->addSql("ALTER TABLE Scoring ADD CONSTRAINT FK_B4CB9B56727ACA70 FOREIGN KEY (parent_id) REFERENCES Scoring (id)");
        $this->addSql("CREATE INDEX IDX_B4CB9B56727ACA70 ON Scoring (parent_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Scoring DROP FOREIGN KEY FK_B4CB9B56727ACA70");
        $this->addSql("DROP INDEX IDX_B4CB9B56727ACA70 ON Scoring");
        $this->addSql("ALTER TABLE Scoring ADD parent INT NOT NULL, DROP parent_id");
    }
}
