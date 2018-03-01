<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140902165926 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE lead_campaign (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lead_source (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE lead ADD lead_campaign INT DEFAULT NULL, ADD lead_source INT DEFAULT NULL");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBB54690DE FOREIGN KEY (lead_campaign) REFERENCES lead_campaign (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB22EB060F FOREIGN KEY (lead_source) REFERENCES lead_source (id)");
        $this->addSql("CREATE INDEX IDX_289161CBB54690DE ON lead (lead_campaign)");
        $this->addSql("CREATE INDEX IDX_289161CB22EB060F ON lead (lead_source)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBB54690DE");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB22EB060F");
        $this->addSql("DROP TABLE lead_campaign");
        $this->addSql("DROP TABLE lead_source");
        $this->addSql("DROP INDEX IDX_289161CBB54690DE ON lead");
        $this->addSql("DROP INDEX IDX_289161CB22EB060F ON lead");
        $this->addSql("ALTER TABLE lead DROP lead_campaign, DROP lead_source");
    }
}
