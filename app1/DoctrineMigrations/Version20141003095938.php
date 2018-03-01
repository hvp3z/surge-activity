<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141003095938 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        

//        $this->addSql("ALTER TABLE lead_subject DROP FOREIGN KEY FK_A20062147C9DFC0C");
//        $this->addSql("ALTER TABLE lead_subject DROP FOREIGN KEY FK_A2006214BC06EA63");
//        $this->addSql("DROP INDEX IDX_A2006214BC06EA63 ON lead_subject");
//        $this->addSql("DROP INDEX IDX_A20062147C9DFC0C ON lead_subject");
//        $this->addSql("ALTER TABLE lead_subject DROP assignee, DROP creator");
        $this->addSql("ALTER TABLE opportunity ADD creator INT DEFAULT NULL, ADD assignee INT DEFAULT NULL");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7BC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D77C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("CREATE INDEX IDX_8389C3D7BC06EA63 ON opportunity (creator)");
        $this->addSql("CREATE INDEX IDX_8389C3D77C9DFC0C ON opportunity (assignee)");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_subject ADD assignee INT DEFAULT NULL, ADD creator INT NOT NULL");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A20062147C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214BC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("CREATE INDEX IDX_A2006214BC06EA63 ON lead_subject (creator)");
        $this->addSql("CREATE INDEX IDX_A20062147C9DFC0C ON lead_subject (assignee)");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7BC06EA63");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D77C9DFC0C");
        $this->addSql("DROP INDEX IDX_8389C3D7BC06EA63 ON opportunity");
        $this->addSql("DROP INDEX IDX_8389C3D77C9DFC0C ON opportunity");
        $this->addSql("ALTER TABLE opportunity DROP creator, DROP assignee");
    }
}
