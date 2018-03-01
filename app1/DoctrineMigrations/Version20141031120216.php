<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141031120216 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, performer INT NOT NULL, performed_at DATETIME NOT NULL, operation_type INT NOT NULL, INDEX IDX_8F3F68C517210BEB (performer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE log ADD CONSTRAINT FK_8F3F68C517210BEB FOREIGN KEY (performer) REFERENCES fos_user (id)");
//        $this->addSql("ALTER TABLE lead_prequalification_driver CHANGE dob dob DATETIME DEFAULT NULL");
//        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EFA599816 FOREIGN KEY (goalCategory) REFERENCES lead_category (id)");
//        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_7B76A2CA9A34590F");
//        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES lead_subject (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE log");
//        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EFA599816");
//        $this->addSql("ALTER TABLE lead_prequalification_driver CHANGE dob dob VARCHAR(255) DEFAULT NULL");
//        $this->addSql("ALTER TABLE scoring DROP FOREIGN KEY FK_7B76A2CA9A34590F");
//        $this->addSql("ALTER TABLE scoring ADD CONSTRAINT FK_7B76A2CA9A34590F FOREIGN KEY (opportunity_id) REFERENCES opportunity (id)");
    }
}
