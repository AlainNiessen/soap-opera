<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811152627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changement de philosophie de string en text pour la longueur';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE philosophie CHANGE philosophie philosophie LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE philosophie CHANGE philosophie philosophie VARCHAR(255) NOT NULL');
    }
}
