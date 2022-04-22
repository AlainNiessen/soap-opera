<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422134128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction type montants et tva';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article CHANGE montant_total montant_total DOUBLE PRECISION NOT NULL, CHANGE montant_total_hors_tva montant_total_hors_tva DOUBLE PRECISION NOT NULL, CHANGE montant_tva montant_tva DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE event CHANGE montant_hors_tva montant_hors_tva DOUBLE PRECISION NOT NULL, CHANGE taux_tva taux_tva DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE montant_total montant_total DOUBLE PRECISION NOT NULL, CHANGE montant_total_tva montant_total_tva DOUBLE PRECISION NOT NULL, CHANGE montant_total_hors_tva montant_total_hors_tva DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE montant_total_hors_tva montant_total_hors_tva DOUBLE PRECISION NOT NULL, CHANGE montant_tva montant_tva DOUBLE PRECISION NOT NULL, CHANGE montant_total montant_total DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article CHANGE montant_total montant_total INT NOT NULL, CHANGE montant_total_hors_tva montant_total_hors_tva INT NOT NULL, CHANGE montant_tva montant_tva INT NOT NULL');
        $this->addSql('ALTER TABLE event CHANGE montant_hors_tva montant_hors_tva INT NOT NULL, CHANGE taux_tva taux_tva INT NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE montant_total montant_total INT NOT NULL, CHANGE montant_total_tva montant_total_tva INT NOT NULL, CHANGE montant_total_hors_tva montant_total_hors_tva INT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE montant_total_hors_tva montant_total_hors_tva INT NOT NULL, CHANGE montant_tva montant_tva INT NOT NULL, CHANGE montant_total montant_total INT NOT NULL');
    }
}
