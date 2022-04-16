<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416131346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Utilisateur';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD langue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B32AADBACD ON utilisateur (langue_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32AADBACD');
        $this->addSql('DROP INDEX IDX_1D1C63B32AADBACD ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP langue_id');
    }
}
