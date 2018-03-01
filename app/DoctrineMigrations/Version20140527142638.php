<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140527142638 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal ADD goalCategory INT DEFAULT NULL, DROP goal_category");
        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EFA599816 FOREIGN KEY (goalCategory) REFERENCES lead_category (id)");
        $this->addSql("CREATE INDEX IDX_FCDCEB2EFA599816 ON goal (goalCategory)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EFA599816");
        $this->addSql("DROP INDEX IDX_FCDCEB2EFA599816 ON goal");
        $this->addSql("ALTER TABLE goal ADD goal_category INT NOT NULL, DROP goalCategory");
    }
}
