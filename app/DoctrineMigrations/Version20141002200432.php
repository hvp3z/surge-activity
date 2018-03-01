<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141002200432 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE lead_subject (id INT AUTO_INCREMENT NOT NULL, creator INT NOT NULL, assignee INT DEFAULT NULL, contact_card INT NOT NULL, lead_category INT DEFAULT NULL, lead_campaign INT DEFAULT NULL, lead_source INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, purchased_at DATETIME DEFAULT NULL, purchase_amount BIGINT DEFAULT NULL, estimated_value BIGINT DEFAULT NULL, previous_carrier_name VARCHAR(255) DEFAULT NULL, previous_carrier_police VARCHAR(255) DEFAULT NULL, previous_carrier_x_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_A2006214BC06EA63 (creator), INDEX IDX_A20062147C9DFC0C (assignee), INDEX IDX_A20062143EEB1A2C (contact_card), INDEX IDX_A2006214AC1F9BC2 (lead_category), INDEX IDX_A2006214B54690DE (lead_campaign), INDEX IDX_A200621422EB060F (lead_source), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (79, 1, 2, 1, 'Lead 1', 2, 1, '2014-07-16 12:00:15', '2014-10-02 20:02:13', 1, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (80, 4, 2, 2, 'Lead 2', 2, 1, '2014-07-16 12:01:23', '2014-09-02 19:32:36', 5, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (81, 1, 2, 3, 'Lead 3', 2, 2, '2014-07-16 12:03:57', '2014-09-02 19:32:51', 2, '2014-03-10 00:00:00', 10000, 9000, 1, 2, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (82, 4, 4, 6, 'Lead 4', 2, 3, '2014-07-16 12:04:51', '2014-09-02 19:33:10', 3, NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (83, 4, 1, 6, 'Lead 5', 1, 1, '2014-07-16 12:05:39', '2014-08-08 16:11:01', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (84, 4, 1, 7, 'Lead 6', 1, 1, '2014-07-16 12:07:51', '2014-10-02 17:51:43', 6, '2009-08-14 00:00:00', 40000, 45000, NULL, NULL, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (85, 1, 2, 7, 'O and O', 1, 1, '2014-08-07 11:09:12', '2014-10-01 15:53:21', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (86, 1, 2, 93, 'Infinity v1', 2, 1, '2014-08-12 14:25:42', '2014-10-01 15:16:02', 2, NULL, 125000, 120000, NULL, NULL, NULL, NULL, NULL, 'lead');
            INSERT INTO `lead_subject` (`id`, `creator`, `assignee`, `contact_card`, `name`, `type`, `status`, `created_at`, `updated_at`, `lead_category`, `purchased_at`, `purchase_amount`, `estimated_value`, `lead_campaign`, `lead_source`, `previous_carrier_name`, `previous_carrier_police`, `previous_carrier_x_date`, `discr`) VALUES (87, 1, 2, 94, 'Larson University', 1, 1, '2014-09-16 03:33:11', '2014-10-02 12:10:12', 1, '2012-01-10 00:00:00', 48000000, 483555, NULL, NULL, NULL, NULL, NULL, 'lead');
            ");

        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214BC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A20062147C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A20062143EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214AC1F9BC2 FOREIGN KEY (lead_category) REFERENCES lead_category (id)");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214B54690DE FOREIGN KEY (lead_campaign) REFERENCES lead_campaign (id)");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A200621422EB060F FOREIGN KEY (lead_source) REFERENCES lead_source (id)");


//        $this->addSql("ALTER TABLE lead_event DROP FOREIGN KEY FK_5D49C728289161CB");
        $this->addSql("ALTER TABLE lead_event ADD CONSTRAINT FK_5D49C728289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");
        $this->addSql("ALTER TABLE lead_prequalification_auto DROP FOREIGN KEY FK_6F32AC20289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_auto ADD CONSTRAINT FK_6F32AC20289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");
        $this->addSql("ALTER TABLE lead_prequalification_driver DROP FOREIGN KEY FK_FED56340289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_driver ADD CONSTRAINT FK_FED56340289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address DROP FOREIGN KEY FK_A607E3DF289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address ADD CONSTRAINT FK_A607E3DF289161CB FOREIGN KEY (lead) REFERENCES lead_subject (id)");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_event DROP FOREIGN KEY FK_5D49C728289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_auto DROP FOREIGN KEY FK_6F32AC20289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_driver DROP FOREIGN KEY FK_FED56340289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address DROP FOREIGN KEY FK_A607E3DF289161CB");
        $this->addSql("CREATE TABLE call_test (status LONGTEXT DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("DROP TABLE lead_subject");

        $this->addSql("ALTER TABLE lead_event DROP FOREIGN KEY FK_5D49C728289161CB");
        $this->addSql("ALTER TABLE lead_event ADD CONSTRAINT FK_5D49C728289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("ALTER TABLE lead_prequalification_auto DROP FOREIGN KEY FK_6F32AC20289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_auto ADD CONSTRAINT FK_6F32AC20289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("ALTER TABLE lead_prequalification_driver DROP FOREIGN KEY FK_FED56340289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_driver ADD CONSTRAINT FK_FED56340289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address DROP FOREIGN KEY FK_A607E3DF289161CB");
        $this->addSql("ALTER TABLE lead_prequalification_insured_address ADD CONSTRAINT FK_A607E3DF289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
    }
}
