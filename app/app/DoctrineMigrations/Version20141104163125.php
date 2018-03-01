<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141104163125 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal CHANGE estimated estimated DOUBLE PRECISION NOT NULL");
        $this->addSql("ALTER TABLE goal_assign CHANGE point point DOUBLE PRECISION NOT NULL, CHANGE percent percent DOUBLE PRECISION NOT NULL, CHANGE items items DOUBLE PRECISION NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal CHANGE estimated estimated INT NOT NULL");
        $this->addSql("ALTER TABLE goal_assign CHANGE point point INT NOT NULL, CHANGE percent percent INT NOT NULL, CHANGE items items INT NOT NULL");
    }
}
