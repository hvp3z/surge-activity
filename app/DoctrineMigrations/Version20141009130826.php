<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141009130826 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE opportunity ADD policy_number VARCHAR(255) NOT NULL, ADD effective_dt VARCHAR(255) NOT NULL, ADD line_code VARCHAR(255) NOT NULL, ADD lsp_code VARCHAR(255) NOT NULL, ADD renewal_count VARCHAR(255) NOT NULL, ADD premium VARCHAR(255) NOT NULL, ADD vehicle_count VARCHAR(255) NOT NULL, ADD homeowners_count VARCHAR(255) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE opportunity DROP policy_number, DROP effective_dt, DROP line_code, DROP lsp_code, DROP renewal_count, DROP premium, DROP vehicle_count, DROP homeowners_count");
    }
}
