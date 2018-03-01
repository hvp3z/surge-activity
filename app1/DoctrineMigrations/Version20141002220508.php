<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141002220508 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB22EB060F");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB3EEB1A2C");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB7C9DFC0C");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBAC1F9BC2");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBB54690DE");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBBC06EA63");
        $this->addSql("DROP INDEX IDX_289161CBBC06EA63 ON lead");
        $this->addSql("DROP INDEX IDX_289161CB7C9DFC0C ON lead");
        $this->addSql("DROP INDEX IDX_289161CB3EEB1A2C ON lead");
        $this->addSql("DROP INDEX IDX_289161CBAC1F9BC2 ON lead");
        $this->addSql("DROP INDEX IDX_289161CBB54690DE ON lead");
        $this->addSql("DROP INDEX IDX_289161CB22EB060F ON lead");
        $this->addSql("ALTER TABLE lead DROP lead_source, DROP contact_card, DROP assignee, DROP lead_category, DROP lead_campaign, DROP creator, DROP name, DROP status, DROP created_at, DROP updated_at, DROP purchased_at, DROP purchase_amount, DROP estimated_value, DROP previous_carrier_name, DROP previous_carrier_police, DROP previous_carrier_x_date, CHANGE id id INT NOT NULL");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBBF396750 FOREIGN KEY (id) REFERENCES lead_subject (id) ON DELETE CASCADE");

        $this->addSql("ALTER TABLE lead_subject DROP type");
       $this->addSql("INSERT INTO `lead_subject` (`id`,  `creator`, `assignee`, `contact_card`, `name`, `status`, `created_at`, `updated_at`, `discr`,  `purchased_at`, `purchase_amount`, `estimated_value`) VALUES (18,  4, 4, 2, 'Lead 2', 3, '2014-07-16 12:24:08', '2014-08-11 15:46:53', 'opportunity',  NULL, NULL, NULL);
INSERT INTO `lead_subject` (`id`,  `creator`, `assignee`, `contact_card`, `name`, `status`, `created_at`, `updated_at`, `discr`,  `purchased_at`, `purchase_amount`, `estimated_value`) VALUES (19,  4, 4, 10, 'Lead 7', 3, '2014-07-16 12:26:31', '2014-08-11 15:46:48', 'opportunity', NULL, NULL, NULL);
INSERT INTO `lead_subject` (`id`,  `creator`, `assignee`, `contact_card`, `name`, `status`, `created_at`, `updated_at`, `discr`,  `purchased_at`, `purchase_amount`, `estimated_value`) VALUES (20,  1, 2, 3, 'Lead 3', 1, '2014-08-07 11:04:27', '2014-08-07 11:04:27', 'opportunity',  '2014-03-10 00:00:00', 10000, 9000);
INSERT INTO `lead_subject` (`id`,  `creator`, `assignee`, `contact_card`, `name`, `status`, `created_at`, `updated_at`, `discr`,  `purchased_at`, `purchase_amount`, `estimated_value`) VALUES (21,  1, 2, 93, 'Infinity v1', 1, '2014-08-12 14:29:42', '2014-08-12 14:29:42', 'opportunity',  NULL, 125000, 120000);
");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D73EEB1A2C");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D77C9DFC0C");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7BC06EA63");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7C1EE0ED6");
        $this->addSql("DROP INDEX IDX_8389C3D7BC06EA63 ON opportunity");
        $this->addSql("DROP INDEX IDX_8389C3D77C9DFC0C ON opportunity");
        $this->addSql("DROP INDEX IDX_8389C3D73EEB1A2C ON opportunity");
        $this->addSql("DROP INDEX IDX_8389C3D7C1EE0ED6 ON opportunity");
        $this->addSql("ALTER TABLE opportunity DROP contact_card, DROP assignee, DROP creator, DROP name, DROP status, DROP created_at, DROP updated_at, DROP opportunityCategory, DROP purchased_at, DROP purchase_amount, DROP estimated_value, CHANGE id id INT NOT NULL");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7BF396750 FOREIGN KEY (id) REFERENCES lead_subject (id) ON DELETE CASCADE");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");


        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBBF396750");
        $this->addSql("ALTER TABLE lead ADD lead_source INT DEFAULT NULL, ADD contact_card INT NOT NULL, ADD assignee INT DEFAULT NULL, ADD lead_category INT DEFAULT NULL, ADD lead_campaign INT DEFAULT NULL, ADD creator INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD status SMALLINT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD purchased_at DATETIME DEFAULT NULL, ADD purchase_amount BIGINT DEFAULT NULL, ADD estimated_value BIGINT DEFAULT NULL, ADD previous_carrier_name VARCHAR(255) DEFAULT NULL, ADD previous_carrier_police VARCHAR(255) DEFAULT NULL, ADD previous_carrier_x_date DATETIME DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB22EB060F FOREIGN KEY (lead_source) REFERENCES lead_source (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB3EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB7C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBAC1F9BC2 FOREIGN KEY (lead_category) REFERENCES lead_category (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBB54690DE FOREIGN KEY (lead_campaign) REFERENCES lead_campaign (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBBC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("CREATE INDEX IDX_289161CBBC06EA63 ON lead (creator)");
        $this->addSql("CREATE INDEX IDX_289161CB7C9DFC0C ON lead (assignee)");
        $this->addSql("CREATE INDEX IDX_289161CB3EEB1A2C ON lead (contact_card)");
        $this->addSql("CREATE INDEX IDX_289161CBAC1F9BC2 ON lead (lead_category)");
        $this->addSql("CREATE INDEX IDX_289161CBB54690DE ON lead (lead_campaign)");
        $this->addSql("CREATE INDEX IDX_289161CB22EB060F ON lead (lead_source)");



        $this->addSql("ALTER TABLE lead_subject ADD type SMALLINT NOT NULL");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7BF396750");
        $this->addSql("ALTER TABLE opportunity ADD contact_card INT NOT NULL, ADD assignee INT DEFAULT NULL, ADD creator INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD status SMALLINT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD opportunityCategory INT DEFAULT NULL, ADD purchased_at DATETIME DEFAULT NULL, ADD purchase_amount BIGINT DEFAULT NULL, ADD estimated_value BIGINT DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D73EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D77C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7BC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7C1EE0ED6 FOREIGN KEY (opportunityCategory) REFERENCES lead_category (id)");
        $this->addSql("CREATE INDEX IDX_8389C3D7BC06EA63 ON opportunity (creator)");
        $this->addSql("CREATE INDEX IDX_8389C3D77C9DFC0C ON opportunity (assignee)");
        $this->addSql("CREATE INDEX IDX_8389C3D73EEB1A2C ON opportunity (contact_card)");
        $this->addSql("CREATE INDEX IDX_8389C3D7C1EE0ED6 ON opportunity (opportunityCategory)");
    }
}
