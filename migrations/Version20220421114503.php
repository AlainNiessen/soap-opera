<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421114503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction table newsletter';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter ADD nom_backend VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE document_pdf document_pdf VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter DROP nom_backend, DROP updated_at, CHANGE document_pdf document_pdf VARCHAR(255) NOT NULL');
    }
}
