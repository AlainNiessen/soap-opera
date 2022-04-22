<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422131854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction type montant et tva pour article';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE montant_hors_tva montant_hors_tva DOUBLE PRECISION NOT NULL, CHANGE taux_tva taux_tva DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE montant_hors_tva montant_hors_tva INT NOT NULL, CHANGE taux_tva taux_tva INT NOT NULL');
    }
}
