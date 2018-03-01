<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141006184546 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227795FD9BB");
        $this->addSql("DROP INDEX UNIQ_51C4C227795FD9BB ON lead_attachment");
        $this->addSql("ALTER TABLE lead_attachment DROP attachment");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE lead_attachment DROP FOREIGN KEY FK_51C4C227289161CB");
        $this->addSql("ALTER TABLE lead_attachment ADD attachment INT NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_51C4C227795FD9BB ON lead_attachment (attachment)");
    }
}
