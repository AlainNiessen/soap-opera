<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417111250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout nom pour le backend + nombre de ventes pour Bestseller';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD nom_backend VARCHAR(255) NOT NULL, ADD nombre_ventes INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP nom_backend, DROP nombre_ventes');
    }
}
