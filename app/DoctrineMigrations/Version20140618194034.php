<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140618194034 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBD2BCC684");
        $this->addSql("DROP INDEX IDX_289161CBD2BCC684 ON lead");
        $this->addSql("ALTER TABLE lead CHANGE leadcategory lead_category INT NOT NULL");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBAC1F9BC2 FOREIGN KEY (lead_category) REFERENCES lead_category (id)");
        $this->addSql("CREATE INDEX IDX_289161CBAC1F9BC2 ON lead (lead_category)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead DROP FOREIGN KEY FK_289161CBAC1F9BC2");
        $this->addSql("DROP INDEX IDX_289161CBAC1F9BC2 ON lead");
        $this->addSql("ALTER TABLE lead CHANGE lead_category leadCategory INT NOT NULL");
        $this->addSql("ALTER TABLE lead ADD CONSTRAINT FK_289161CBD2BCC684 FOREIGN KEY (leadCategory) REFERENCES lead_category (id)");
        $this->addSql("CREATE INDEX IDX_289161CBD2BCC684 ON lead (leadCategory)");
    }
}
