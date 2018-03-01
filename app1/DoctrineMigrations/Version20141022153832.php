<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141022153832 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
//        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");
//        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227795FD9BB FOREIGN KEY (attachment) REFERENCES attachment (id)");
//        $this->addSql("CREATE INDEX IDX_51C4C227289161CB ON lead_attachment (lead)");
//        $this->addSql("CREATE INDEX IDX_51C4C227795FD9BB ON lead_attachment (attachment)");
        $this->addSql("ALTER TABLE lead_subject CHANGE contact_card contact_card INT DEFAULT NULL");
//        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EFA599816 FOREIGN KEY (goalCategory) REFERENCES lead_category (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
//        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EFA599816");
//        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227289161CB");
//        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227795FD9BB");
//        $this->addSql("DROP INDEX IDX_51C4C227289161CB ON lead_attachment");
//        $this->addSql("DROP INDEX IDX_51C4C227795FD9BB ON lead_attachment");
        $this->addSql("ALTER TABLE lead_subject CHANGE contact_card contact_card INT NOT NULL");
    }
}
