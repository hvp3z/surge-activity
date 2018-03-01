<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141010091348 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE opportunity CHANGE policy_number policy_number VARCHAR(255) DEFAULT NULL, CHANGE effective_dt effective_dt VARCHAR(255) DEFAULT NULL, CHANGE line_code line_code VARCHAR(255) DEFAULT NULL, CHANGE lsp_code lsp_code VARCHAR(255) DEFAULT NULL, CHANGE renewal_count renewal_count VARCHAR(255) DEFAULT NULL, CHANGE premium premium VARCHAR(255) DEFAULT NULL, CHANGE vehicle_count vehicle_count VARCHAR(255) DEFAULT NULL, CHANGE homeowners_count homeowners_count VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE opportunity CHANGE policy_number policy_number VARCHAR(255) NOT NULL, CHANGE effective_dt effective_dt VARCHAR(255) NOT NULL, CHANGE line_code line_code VARCHAR(255) NOT NULL, CHANGE lsp_code lsp_code VARCHAR(255) NOT NULL, CHANGE renewal_count renewal_count VARCHAR(255) NOT NULL, CHANGE premium premium VARCHAR(255) NOT NULL, CHANGE vehicle_count vehicle_count VARCHAR(255) NOT NULL, CHANGE homeowners_count homeowners_count VARCHAR(255) NOT NULL");
    }
}
