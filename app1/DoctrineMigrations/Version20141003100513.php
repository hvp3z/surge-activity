<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141003100513 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead ADD creator INT DEFAULT NULL, ADD assignee INT DEFAULT NULL");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBBC06EA63 FOREIGN KEY (creator) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CB7C9DFC0C FOREIGN KEY (assignee) REFERENCES fos_user (id)");
        $this->addSql("CREATE INDEX IDX_289161CBBC06EA63 ON lead (creator)");
        $this->addSql("CREATE INDEX IDX_289161CB7C9DFC0C ON lead (assignee)");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        

        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBBC06EA63");
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CB7C9DFC0C");
        $this->addSql("DROP INDEX IDX_289161CBBC06EA63 ON lead");
        $this->addSql("DROP INDEX IDX_289161CB7C9DFC0C ON lead");
        $this->addSql("ALTER TABLE lead DROP creator, DROP assignee");

    }
}
