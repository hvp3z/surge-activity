<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141111132159 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_type DROP is_system");
        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_7B76A2CA9A34590F");
        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES lead_subject (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_type ADD is_system TINYINT(1) DEFAULT '0' NOT NULL");
        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_7B76A2CA9A34590F");
        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES opportunity (id)");
    }
}
