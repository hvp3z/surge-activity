<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160817105321 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE scoring_criteria ADD company INT DEFAULT NULL');
        $this->addSql('ALTER TABLE scoring_criteria ADD CONSTRAINT FK_B303AFD54FBF094F FOREIGN KEY (company) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_B303AFD54FBF094F ON scoring_criteria (company)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE scoring_criteria DROP FOREIGN KEY FK_B303AFD54FBF094F');
        $this->addSql('DROP INDEX IDX_B303AFD54FBF094F ON scoring_criteria');
        $this->addSql('ALTER TABLE scoring_criteria DROP company');
    }
}
