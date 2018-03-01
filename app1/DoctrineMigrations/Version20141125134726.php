<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141125134726 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE milestone_operation (id INT AUTO_INCREMENT NOT NULL, performer INT NOT NULL, lead_subject INT NOT NULL, performed_at DATETIME NOT NULL, operation_type INT NOT NULL, INDEX IDX_A694159517210BEB (performer), INDEX IDX_A6941595A2006214 (lead_subject), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE milestone_operation ADD CONSTRAINT FK_A694159517210BEB FOREIGN KEY (performer) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE milestone_operation ADD CONSTRAINT FK_A6941595A2006214 FOREIGN KEY (lead_subject) REFERENCES lead_subject (id)");
        $this->addSql("DROP TABLE milestoneoperation");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE milestoneoperation (id INT AUTO_INCREMENT NOT NULL, lead_subject INT NOT NULL, performer INT NOT NULL, performed_at DATETIME NOT NULL, operation_type INT NOT NULL, INDEX IDX_2D2437AD17210BEB (performer), INDEX IDX_2D2437ADA2006214 (lead_subject), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE milestoneoperation ADD CONSTRAINT FK_2D2437ADA2006214 FOREIGN KEY (lead_subject) REFERENCES lead_subject (id)");
        $this->addSql("ALTER TABLE milestoneoperation ADD CONSTRAINT FK_2D2437AD17210BEB FOREIGN KEY (performer) REFERENCES fos_user (id)");
        $this->addSql("DROP TABLE milestone_operation");
    }
}
