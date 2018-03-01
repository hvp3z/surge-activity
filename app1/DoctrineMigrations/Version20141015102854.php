<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141015102854 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE operation ADD orphanRemoval INT DEFAULT NULL");
        $this->addSql("ALTER TABLE operation ADD CONSTRAINT FK_1981A66DE284468DAE73632 FOREIGN KEY (entity, orphanRemoval) REFERENCES lead_subject (id)");
        $this->addSql("CREATE INDEX IDX_1981A66DE284468DAE73632 ON operation (entity, orphanRemoval)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DE284468DAE73632");
        $this->addSql("DROP INDEX IDX_1981A66DE284468DAE73632 ON operation");
        $this->addSql("ALTER TABLE operation DROP orphanRemoval");
    }
}
