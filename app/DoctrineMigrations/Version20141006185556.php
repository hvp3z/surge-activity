<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141006185556 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227795FD9BB");
        $this->addSql("ALTER TABLE lead_attachment ADD lead INT NOT NULL");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227795FD9BB FOREIGN KEY (attachment) REFERENCES attachment (id)");
        $this->addSql("CREATE INDEX IDX_51C4C227289161CB ON lead_attachment (lead)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227289161CB");
        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227795FD9BB");
        $this->addSql("DROP INDEX IDX_51C4C227289161CB ON lead_attachment");
        $this->addSql("ALTER TABLE lead_attachment DROP lead");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227795FD9BB FOREIGN KEY (attachment) REFERENCES attachment (id) ON DELETE CASCADE");
    }
}
