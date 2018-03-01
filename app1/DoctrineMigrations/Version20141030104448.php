<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141030104448 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE goal ADD goalCategory_id INT DEFAULT NULL, DROP goalCategory");
        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2ED5C5F34A FOREIGN KEY (goalCategory_id) REFERENCES lead_category (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_FCDCEB2ED5C5F34A ON goal (goalCategory_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2ED5C5F34A");
        $this->addSql("DROP INDEX UNIQ_FCDCEB2ED5C5F34A ON goal");
        $this->addSql("ALTER TABLE goal ADD goalCategory INT NOT NULL, DROP goalCategory_id");;
    }
}
