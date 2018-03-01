<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141030105232 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2ED5C5F34A");
        $this->addSql("DROP INDEX UNIQ_FCDCEB2ED5C5F34A ON goal");
        $this->addSql("ALTER TABLE goal CHANGE goalcategory_id goal_category INT DEFAULT NULL");
        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EB2368CF4 FOREIGN KEY (goal_category) REFERENCES lead_category (id) ON DELETE SET NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_FCDCEB2EB2368CF4 ON goal (goal_category)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EB2368CF4");
        $this->addSql("DROP INDEX UNIQ_FCDCEB2EB2368CF4 ON goal");
        $this->addSql("ALTER TABLE goal CHANGE goal_category goalCategory_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2ED5C5F34A FOREIGN KEY (goalCategory_id) REFERENCES lead_category (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_FCDCEB2ED5C5F34A ON goal (goalCategory_id)");
    }
}
