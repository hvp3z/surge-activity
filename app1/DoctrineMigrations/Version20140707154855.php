<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140707154855 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE opportunity_attachment (id INT AUTO_INCREMENT NOT NULL, attachment INT NOT NULL, opportunity INT NOT NULL, UNIQUE INDEX UNIQ_B8BA5574795FD9BB (attachment), INDEX IDX_B8BA55748389C3D7 (opportunity), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE opportunity_attachment ADD CONSTRAINT FK_B8BA5574795FD9BB FOREIGN KEY (attachment) REFERENCES attachment (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE opportunity_attachment ADD CONSTRAINT FK_B8BA55748389C3D7 FOREIGN KEY (opportunity) REFERENCES opportunity (id)");
        $this->addSql("ALTER TABLE lead_attachment CHANGE lead lead INT NOT NULL, CHANGE attachment attachment INT NOT NULL");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227795FD9BB FOREIGN KEY (attachment) REFERENCES attachment (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE lead_attachment ADD CONSTRAINT FK_51C4C227289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_51C4C227795FD9BB ON lead_attachment (attachment)");
        $this->addSql("CREATE INDEX IDX_51C4C227289161CB ON lead_attachment (lead)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE opportunity_attachment");
        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227795FD9BB");
        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227289161CB");
        $this->addSql("DROP INDEX UNIQ_51C4C227795FD9BB ON lead_attachment");
        $this->addSql("DROP INDEX IDX_51C4C227289161CB ON lead_attachment");
        $this->addSql("ALTER TABLE lead_attachment CHANGE attachment attachment INT DEFAULT NULL, CHANGE lead lead INT DEFAULT NULL");
    }
}
