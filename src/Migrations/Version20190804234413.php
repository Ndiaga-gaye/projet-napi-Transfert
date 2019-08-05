<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804234413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC493F09F5');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCBFD610BF');
        $this->addSql('DROP INDEX IDX_47948BBC493F09F5 ON depot');
        $this->addSql('DROP INDEX numero_compte_2 ON depot');
        $this->addSql('DROP INDEX IDX_47948BBCBFD610BF ON depot');
        $this->addSql('DROP INDEX numero_compte ON depot');
        $this->addSql('ALTER TABLE depot DROP comptedepot_id, CHANGE numero_compte numero_compte INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot ADD comptedepot_id INT NOT NULL, CHANGE numero_compte numero_compte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC493F09F5 FOREIGN KEY (comptedepot_id) REFERENCES creation_compte (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCBFD610BF FOREIGN KEY (numero_compte) REFERENCES creation_compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC493F09F5 ON depot (comptedepot_id)');
        $this->addSql('CREATE INDEX numero_compte_2 ON depot (numero_compte)');
        $this->addSql('CREATE INDEX IDX_47948BBCBFD610BF ON depot (numero_compte)');
        $this->addSql('CREATE UNIQUE INDEX numero_compte ON depot (numero_compte)');
    }
}
