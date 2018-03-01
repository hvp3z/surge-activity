<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140625144037 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_card ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE lead DROP first_name, DROP last_name");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7289161CB");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7289161CB FOREIGN KEY (lead) REFERENCES lead (id) ON DELETE SET NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE contact_card DROP first_name, DROP last_name");
        $this->addSql("ALTER TABLE lead ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7289161CB");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7289161CB FOREIGN KEY (lead) REFERENCES lead (id) ON UPDATE CASCADE ON DELETE SET NULL");
    }
}
