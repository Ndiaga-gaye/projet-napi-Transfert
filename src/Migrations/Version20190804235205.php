<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804235205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot ADD creationcompte_id INT NOT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC6459A42 FOREIGN KEY (creationcompte_id) REFERENCES creation_compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC6459A42 ON depot (creationcompte_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC6459A42');
        $this->addSql('DROP INDEX IDX_47948BBC6459A42 ON depot');
        $this->addSql('ALTER TABLE depot DROP creationcompte_id');
    }
}
