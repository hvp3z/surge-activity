<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141103111956 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE goal_assign (id INT AUTO_INCREMENT NOT NULL, goal INT NOT NULL, assignee INT NOT NULL, point INT NOT NULL, percent INT NOT NULL, items INT NOT NULL, INDEX IDX_E8A5DCE5FCDCEB2E (goal), INDEX IDX_E8A5DCE57C9DFC0C (assignee), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE goal_assign ADD CONSTRAINT FK_E8A5DCE5FCDCEB2E FOREIGN KEY (goal) REFERENCES goal (id)");
        $this->addSql("ALTER TABLE goal_assign ADD CONSTRAINT FK_E8A5DCE57C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE goal_assign");
    }
}
