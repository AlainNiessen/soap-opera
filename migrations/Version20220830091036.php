<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830091036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop dates affichage pour promotions';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion DROP date_affichage_start, DROP date_affichage_end');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion ADD date_affichage_start DATETIME NOT NULL, ADD date_affichage_end DATETIME NOT NULL');
    }
}
