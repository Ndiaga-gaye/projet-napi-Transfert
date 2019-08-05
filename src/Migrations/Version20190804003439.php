<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804003439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492FA2BD44');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP INDEX IDX_8D93D6492FA2BD44 ON user');
        $this->addSql('ALTER TABLE user DROP profiluser_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, userprofil_id INT NOT NULL, libeller VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_E6D6B297E9137118 (userprofil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user ADD profiluser_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492FA2BD44 FOREIGN KEY (profiluser_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492FA2BD44 ON user (profiluser_id)');
    }
}
