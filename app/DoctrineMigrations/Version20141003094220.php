<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141003094220 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE opportunity ADD opportunityCategory INT DEFAULT NULL");
        $this->addSql("ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7C1EE0ED6 FOREIGN KEY (opportunityCategory) REFERENCES lead_category (id)");
        $this->addSql("CREATE INDEX IDX_8389C3D7C1EE0ED6 ON opportunity (opportunityCategory)");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        


        $this->addSql("ALTER TABLE opportunity DROP FOREIGN KEY FK_8389C3D7C1EE0ED6");
        $this->addSql("DROP INDEX IDX_8389C3D7C1EE0ED6 ON opportunity");
        $this->addSql("ALTER TABLE opportunity DROP opportunityCategory");
    }
}
