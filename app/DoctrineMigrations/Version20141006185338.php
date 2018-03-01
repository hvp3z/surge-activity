<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141006185338 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227289161CB");
        $this->addSql("DROP INDEX IDX_51C4C227289161CB ON lead_attachment");
        $this->addSql("ALTER TABLE lead_attachment CHANGE lead attachment INT NOT NULL");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227795FD9BB FOREIGN KEY (attachment) REFERENCES attachment (id) ON DELETE CASCADE");
        $this->addSql("CREATE INDEX IDX_51C4C227795FD9BB ON lead_attachment (attachment)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227795FD9BB");
        $this->addSql("DROP INDEX IDX_51C4C227795FD9BB ON lead_attachment");
        $this->addSql("ALTER TABLE lead_attachment CHANGE attachment lead INT NOT NULL");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");
        $this->addSql("CREATE INDEX IDX_51C4C227289161CB ON lead_attachment (lead)");
    }
}
