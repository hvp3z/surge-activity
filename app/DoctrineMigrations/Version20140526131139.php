<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140526131139 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, creator INT NOT NULL, assignee INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, starts_at DATETIME NOT NULL, finishes_at DATETIME DEFAULT NULL, type INT NOT NULL, custom_type VARCHAR(255) DEFAULT NULL, INDEX IDX_AC74095ABC06EA63 (creator), INDEX IDX_AC74095A7C9DFC0C (assignee), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, contact_card INT DEFAULT NULL, type SMALLINT NOT NULL, name VARCHAR(255) DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_4C62E6383EEB1A2C (contact_card), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE contact_card (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, creator INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, starts_at DATETIME NOT NULL, finishes_at DATETIME NOT NULL, global TINYINT(1) DEFAULT NULL, type INT NOT NULL, estimated INT NOT NULL, INDEX IDX_FCDCEB2EBC06EA63 (creator), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE goal_assignment (id INT AUTO_INCREMENT NOT NULL, goal INT NOT NULL, assignee INT NOT NULL, status INT NOT NULL, current INT DEFAULT NULL, INDEX IDX_129155BDFCDCEB2E (goal), INDEX IDX_129155BD7C9DFC0C (assignee), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lead (id INT AUTO_INCREMENT NOT NULL, creator INT NOT NULL, assignee INT DEFAULT NULL, contact_card INT NOT NULL, name VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, leadCategory INT NOT NULL, INDEX IDX_289161CBBC06EA63 (creator), INDEX IDX_289161CB7C9DFC0C (assignee), INDEX IDX_289161CB3EEB1A2C (contact_card), INDEX IDX_289161CBD2BCC684 (leadCategory), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lead_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, performer INT NOT NULL, performed_at DATETIME NOT NULL, operation_type INT NOT NULL, INDEX IDX_1981A66D17210BEB (performer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE opportunity (id INT AUTO_INCREMENT NOT NULL, lead INT DEFAULT NULL, creator INT NOT NULL, assignee INT DEFAULT NULL, contact_card INT NOT NULL, name VARCHAR(255) NOT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, price INT DEFAULT NULL, opportunityCategory INT NOT NULL, UNIQUE INDEX UNIQ_8389C3D7289161CB (lead), INDEX IDX_8389C3D7BC06EA63 (creator), INDEX IDX_8389C3D77C9DFC0C (assignee), INDEX IDX_8389C3D73EEB1A2C (contact_card), INDEX IDX_8389C3D7C1EE0ED6 (opportunityCategory), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, widgets_data LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE widget (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, service_id VARCHAR(255) NOT NULL, height INT NOT NULL, width INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acl_classes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_type VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_69DD750638A36066 (class_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acl_security_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(200) NOT NULL, username TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8835EE78772E836AF85E0677 (identifier, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acl_object_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_object_identity_id INT UNSIGNED DEFAULT NULL, class_id INT UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 (object_identifier, class_id), INDEX IDX_9407E54977FA751A (parent_object_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acl_object_identity_ancestors (object_identity_id INT UNSIGNED NOT NULL, ancestor_id INT UNSIGNED NOT NULL, INDEX IDX_825DE2993D9AB4A6 (object_identity_id), INDEX IDX_825DE299C671CEA1 (ancestor_id), PRIMARY KEY(object_identity_id, ancestor_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE acl_entries (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_id INT UNSIGNED NOT NULL, object_identity_id INT UNSIGNED DEFAULT NULL, security_identity_id INT UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INT NOT NULL, granting TINYINT(1) NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success TINYINT(1) NOT NULL, audit_failure TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 (class_id, object_identity_id, field_name, ace_order), INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 (class_id, object_identity_id, security_identity_id), INDEX IDX_46C8B806EA000B10 (class_id), INDEX IDX_46C8B8063D9AB4A6 (object_identity_id), INDEX IDX_46C8B806DF9183C9 (security_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE activity ADD CONSTRAINT FK_AC74095ABC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE activity ADD CONSTRAINT FK_AC74095A7C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE contact ADD CONSTRAINT FK_4C62E6383EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EBC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE goal_assignment ADD CONSTRAINT FK_129155BDFCDCEB2E FOREIGN KEY (goal) REFERENCES goal (id)");
        $this->addSql("ALTER TABLE goal_assignment ADD CONSTRAINT FK_129155BD7C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBBC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB7C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB3EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBD2BCC684 FOREIGN KEY (leadCategory) REFERENCES lead_category (id)");
        $this->addSql("ALTER TABLE operation ADD CONSTRAINT FK_1981A66D17210BEB FOREIGN KEY (performer) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7289161CB FOREIGN KEY (lead) REFERENCES lead (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7BC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D77C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D73EEB1A2C FOREIGN KEY (contact_card) REFERENCES contact_card (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7C1EE0ED6 FOREIGN KEY (opportunityCategory) REFERENCES lead_category (id)");
        $this->addSql("ALTER TABLE acl_object_identities ADD CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id)");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6383EEB1A2C");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB3EEB1A2C");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D73EEB1A2C");
        $this->addSql("ALTER TABLE goal_assignment DROP FOREIGN KEY FK_129155BDFCDCEB2E");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7289161CB");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBD2BCC684");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7C1EE0ED6");
        $this->addSql("ALTER TABLE activity DROP FOREIGN KEY FK_AC74095ABC06EA63");
        $this->addSql("ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A7C9DFC0C");
        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EBC06EA63");
        $this->addSql("ALTER TABLE goal_assignment DROP FOREIGN KEY FK_129155BD7C9DFC0C");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBBC06EA63");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB7C9DFC0C");
        $this->addSql("ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D17210BEB");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7BC06EA63");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D77C9DFC0C");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9");
        $this->addSql("ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6");
        $this->addSql("DROP TABLE activity");
        $this->addSql("DROP TABLE contact");
        $this->addSql("DROP TABLE contact_card");
        $this->addSql("DROP TABLE goal");
        $this->addSql("DROP TABLE goal_assignment");
        $this->addSql("DROP TABLE lead");
        $this->addSql("DROP TABLE lead_category");
        $this->addSql("DROP TABLE operation");
        $this->addSql("DROP TABLE opportunity");
        $this->addSql("DROP TABLE fos_user");
        $this->addSql("DROP TABLE widget");
        $this->addSql("DROP TABLE acl_classes");
        $this->addSql("DROP TABLE acl_security_identities");
        $this->addSql("DROP TABLE acl_object_identities");
        $this->addSql("DROP TABLE acl_object_identity_ancestors");
        $this->addSql("DROP TABLE acl_entries");
    }
}
