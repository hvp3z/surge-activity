<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141024170931 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE lead_subject ADD contact_card_opportunity INT DEFAULT NULL");
        $this->addSql("ALTER TABLE lead_subject ADD CONSTRAINT FK_A2006214A5A796D9 FOREIGN KEY (contact_card_opportunity) REFERENCES contact_card (id)");
        $this->addSql("CREATE INDEX IDX_A2006214A5A796D9 ON lead_subject (contact_card_opportunity)");
//        $this->addSql("ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EFA599816 FOREIGN KEY (goalCategory) REFERENCES lead_category (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
//        $this->addSql("ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EFA599816");
        $this->addSql("ALTER TABLE lead_subject DROP FOREIGN KEY FK_A2006214A5A796D9");
        $this->addSql("DROP INDEX IDX_A2006214A5A796D9 ON lead_subject");
        $this->addSql("ALTER TABLE lead_subject DROP contact_card_opportunity");
    }
}
