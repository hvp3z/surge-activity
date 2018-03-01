<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140918152516 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE lead_prequalification_auto (id INT AUTO_INCREMENT NOT NULL, lead INT NOT NULL, year INT NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, vin_number VARCHAR(255) NOT NULL, date_purchased DATETIME NOT NULL, INDEX IDX_6F32AC20289161CB (lead), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lead_prequalification_driver (id INT AUTO_INCREMENT NOT NULL, lead INT NOT NULL, name VARCHAR(255) NOT NULL, dob VARCHAR(255) NOT NULL, license VARCHAR(255) NOT NULL, ageLicensed INT NOT NULL, tickets VARCHAR(255) NOT NULL, INDEX IDX_FED56340289161CB (lead), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lead_prequalification_insured_address (id INT AUTO_INCREMENT NOT NULL, lead INT NOT NULL, isOwn TINYINT(1) NOT NULL, isRent TINYINT(1) NOT NULL, home VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zipCode VARCHAR(255) NOT NULL, tickets VARCHAR(255) NOT NULL, INDEX IDX_A607E3DF289161CB (lead), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE lead_prequalification_auto ADD CONSTRAINT FK_6F32AC20289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("ALTER TABLE lead_prequalification_driver ADD CONSTRAINT FK_FED56340289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address ADD CONSTRAINT FK_A607E3DF289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE lead_prequalification_auto");
        $this->addSql("DROP TABLE lead_prequalification_driver");
        $this->addSql("DROP TABLE lead_prequalification_insured_address");
    }
}
