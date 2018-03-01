<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141103152036 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
//
//        $this->addSql("CREATE TABLE attachment_audit (id INT NOT NULL, rev INT NOT NULL, creator INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE contact_audit (id INT NOT NULL, rev INT NOT NULL, contact_card INT DEFAULT NULL, type SMALLINT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, donot_call INT DEFAULT NULL, dnc TINYINT(1) DEFAULT NULL, donot_email TINYINT(1) DEFAULT NULL, is_default TINYINT(1) DEFAULT '0', revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE contact_card_audit (id INT NOT NULL, rev INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, middle_initial VARCHAR(8) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, street_address VARCHAR(255) DEFAULT NULL, city VARCHAR(127) DEFAULT NULL, state VARCHAR(4) DEFAULT NULL, zip VARCHAR(6) DEFAULT NULL, type SMALLINT DEFAULT NULL, isOpportunity SMALLINT DEFAULT NULL, other VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE lead_audit (id INT NOT NULL,
//         `contact_card` INT(11) NULL DEFAULT NULL,
//	`lead_category` INT(11) NULL DEFAULT NULL,
//	`lead_campaign` INT(11) NULL DEFAULT NULL,
//	`lead_source` INT(11) NULL DEFAULT NULL,
//	`name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
//	`status` SMALLINT(6) NOT NULL,
//	`purchased_at` DATETIME NULL DEFAULT NULL,
//	`purchase_amount` BIGINT(20) NULL DEFAULT NULL,
//	`estimated_value` BIGINT(20) NULL DEFAULT NULL,
//	`previous_carrier_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
//	`previous_carrier_police` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
//	`previous_carrier_x_date` DATETIME NULL DEFAULT NULL,
//	`created_at` DATETIME NOT NULL,
//	`updated_at` DATETIME NOT NULL,
//
//	`quantity` INT(11) NULL DEFAULT NULL,
//	`contact_card_opportunity` INT(11) NULL DEFAULT NULL,
//         rev INT NOT NULL, creator INT DEFAULT NULL, assignee INT DEFAULT NULL, type SMALLINT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE lead_attachment_audit (id INT NOT NULL, rev INT NOT NULL, lead INT DEFAULT NULL, attachment INT DEFAULT NULL,
//
//         revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE lead_campaign_audit (id INT NOT NULL, rev INT NOT NULL, title VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE lead_category_audit (id INT NOT NULL, rev INT NOT NULL, title VARCHAR(255) DEFAULT NULL, effective_date INT DEFAULT NULL, review INT DEFAULT NULL, points INT DEFAULT NULL, value INT DEFAULT NULL, line_code VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE lead_event_type_audit (id INT NOT NULL, rev INT NOT NULL, title VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE lead_source_audit (id INT NOT NULL, rev INT NOT NULL, title VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE opportunity_audit (id INT NOT NULL,
//         `contact_card` INT(11) NULL DEFAULT NULL,
//	`lead_category` INT(11) NULL DEFAULT NULL,
//	`lead_campaign` INT(11) NULL DEFAULT NULL,
//	`lead_source` INT(11) NULL DEFAULT NULL,
//	`name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
//	`status` SMALLINT(6) NOT NULL,
//	`purchased_at` DATETIME NULL DEFAULT NULL,
//	`purchase_amount` BIGINT(20) NULL DEFAULT NULL,
//	`estimated_value` BIGINT(20) NULL DEFAULT NULL,
//	`previous_carrier_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
//	`previous_carrier_police` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
//	`previous_carrier_x_date` DATETIME NULL DEFAULT NULL,
//	`created_at` DATETIME NOT NULL,
//	`updated_at` DATETIME NOT NULL,
//	`discr` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
//	`quantity` INT(11) NULL DEFAULT NULL,
//	`contact_card_opportunity` INT(11) NULL DEFAULT NULL,
//         rev INT NOT NULL, lead INT DEFAULT NULL, creator INT DEFAULT NULL, assignee INT DEFAULT NULL, price INT DEFAULT NULL, policy_number VARCHAR(255) DEFAULT NULL, effective_dt VARCHAR(255) DEFAULT NULL, line_code VARCHAR(255) DEFAULT NULL, lsp_code VARCHAR(255) DEFAULT NULL, renewal_count VARCHAR(255) DEFAULT NULL, premium VARCHAR(255) DEFAULT NULL, vehicle_count VARCHAR(255) DEFAULT NULL, homeowners_count VARCHAR(255) DEFAULT NULL, closing_date DATETIME DEFAULT NULL, effective_date DATETIME DEFAULT NULL, priority INT DEFAULT NULL, quotedAmount INT DEFAULT NULL, opportunityCategory INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE opportunity_attachment_audit (id INT NOT NULL, rev INT NOT NULL, attachment INT DEFAULT NULL, opportunity INT DEFAULT NULL,
//
//
//        revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE fos_user_audit (id INT NOT NULL, rev INT NOT NULL, username VARCHAR(255) DEFAULT NULL, username_canonical VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, email_canonical VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) DEFAULT NULL, expired TINYINT(1) DEFAULT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) DEFAULT NULL, credentials_expire_at DATETIME DEFAULT NULL, widgets_data LONGTEXT DEFAULT NULL, lsp_code VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE leads_regeneration_audit (id INT NOT NULL, rev INT NOT NULL, lead_id INT DEFAULT NULL, regenerationAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE goal_audit (id INT NOT NULL, rev INT NOT NULL, creator INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, startsAt DATETIME DEFAULT NULL, finishesAt DATETIME DEFAULT NULL, period INT DEFAULT NULL, estimated INT DEFAULT NULL, total INT DEFAULT NULL, goalCategory INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE goal_assignment_audit (id INT NOT NULL, rev INT NOT NULL, goal INT DEFAULT NULL, assignee INT DEFAULT NULL, estimated INT DEFAULT NULL, status INT DEFAULT NULL, current INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE call_reporting_audit (id INT NOT NULL, rev INT NOT NULL, contact INT DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, starts_at DATETIME DEFAULT NULL, duration TIME DEFAULT NULL, status INT DEFAULT NULL, type INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE scoring_audit (id INT NOT NULL, rev INT NOT NULL, opportunity_id INT DEFAULT NULL, lead_id INT DEFAULT NULL, scoring LONGTEXT DEFAULT NULL, total INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE scoring_criteria_audit (id INT NOT NULL, rev INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, score INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("CREATE TABLE revisions (id INT AUTO_INCREMENT NOT NULL, timestamp DATETIME NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
//        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EFA599816 FOREIGN KEY (goalCategory) REFERENCES lead_category (id)");
//        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_7B76A2CA9A34590F");
//        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES lead_subject (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
//        $this->addSql("DROP TABLE attachment_audit");
//        $this->addSql("DROP TABLE contact_audit");
//        $this->addSql("DROP TABLE contact_card_audit");
//        $this->addSql("DROP TABLE lead_audit");
//        $this->addSql("DROP TABLE lead_attachment_audit");
//        $this->addSql("DROP TABLE lead_campaign_audit");
//        $this->addSql("DROP TABLE lead_category_audit");
//        $this->addSql("DROP TABLE lead_event_type_audit");
//        $this->addSql("DROP TABLE lead_source_audit");
//        $this->addSql("DROP TABLE opportunity_audit");
//        $this->addSql("DROP TABLE opportunity_attachment_audit");
//        $this->addSql("DROP TABLE fos_user_audit");
//        $this->addSql("DROP TABLE leads_regeneration_audit");
//        $this->addSql("DROP TABLE goal_audit");
//        $this->addSql("DROP TABLE goal_assignment_audit");
//        $this->addSql("DROP TABLE call_reporting_audit");
//        $this->addSql("DROP TABLE scoring_audit");
//        $this->addSql("DROP TABLE scoring_criteria_audit");
//        $this->addSql("DROP TABLE revisions");
//        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EFA599816");
//        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_7B76A2CA9A34590F");
//        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES opportunity (id)");
    }
}
