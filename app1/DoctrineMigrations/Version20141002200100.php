<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141002200100 extends AbstractMigration
{
    public function up(Schema $schema)
    {
//        // this up() migration is auto-generated, please modify it to your needs
//        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
//
//        $this->addSql("CREATE TABLE lead_subject (id INT AUTO_INCREMENT NOT NULL, creator INT NOT NULL, assignee INT DEFAULT NULL, contact_card INT NOT NULL, lead_category INT DEFAULT NULL, lead_campaign INT DEFAULT NULL, lead_source INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, purchased_at DATETIME DEFAULT NULL, purchase_amount BIGINT DEFAULT NULL, estimated_value BIGINT DEFAULT NULL, previous_carrier_name VARCHAR(255) DEFAULT NULL, previous_carrier_police VARCHAR(255) DEFAULT NULL, previous_carrier_x_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_A2006214BC06EA63 (creator), INDEX IDX_A20062147C9DFC0C (assignee), INDEX IDX_A20062143EEB1A2C (contact_card), INDEX IDX_A2006214AC1F9BC2 (lead_category), INDEX IDX_A2006214B54690DE (lead_campaign), INDEX IDX_A200621422EB060F (lead_source), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214BC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
//        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A20062147C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
//        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A20062143EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
//        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214AC1F9BC2 FOREIGN KEY (lead_category) REFERENCES lead_category (id)");
//        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214B54690DE FOREIGN KEY (lead_campaign) REFERENCES lead_campaign (id)");
//        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A200621422EB060F FOREIGN KEY (lead_source) REFERENCES lead_source (id)");


    }

    public function down(Schema $schema)
    {
//        // this down() migration is auto-generated, please modify it to your needs
//        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
//
//        $this->addSql("CREATE TABLE call_test (status LONGTEXT DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("DROP TABLE lead_subject");

    }
}
