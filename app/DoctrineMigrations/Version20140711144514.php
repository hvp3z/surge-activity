<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140711144514 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_B4CB9B56727ACA70");
        $this->addSql("CREATE TABLE scoring_criteria (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, score INT NOT NULL, INDEX IDX_B303AFD5727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE scoring_criteria ADD CONSTRAINT FK_B303AFD5727ACA70 FOREIGN KEY (parent_id) REFERENCES scoring_criteria (id)");
        $this->addSql("DROP TABLE scoring");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE scoring_criteria DROP FOREIGN KEY FK_B303AFD5727ACA70");
        $this->addSql("CREATE TABLE scoring (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, score INT NOT NULL, INDEX IDX_B4CB9B56727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_B4CB9B56727ACA70 FOREIGN KEY (parent_id) REFERENCES Scoring (id)");
        $this->addSql("DROP TABLE scoring_criteria");
    }
}
