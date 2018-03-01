<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140711151459 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE scoring (id INT AUTO_INCREMENT NOT NULL, opportunity_id INT DEFAULT NULL, lead_id INT DEFAULT NULL, scoring LONGTEXT NOT NULL, total INT NOT NULL, UNIQUE INDEX UNIQ_7B76A2CA9A34590F (opportunity_id), UNIQUE INDEX UNIQ_7B76A2CA55458D (lead_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES opportunity (id)");
        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA55458D FOREIGN KEY (lead_id) REFERENCES lead (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE scoring");
    }
}
