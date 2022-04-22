<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422094906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changement montant et tva en float';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE montant_hors_tva montant_hors_tva FLOAT NOT NULL, CHANGE taux_tva taux_tva FLOAT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE montant_hors_tva montant_hors_tva INT NOT NULL, CHANGE taux_tva taux_tva INT NOT NULL');
    }
}
