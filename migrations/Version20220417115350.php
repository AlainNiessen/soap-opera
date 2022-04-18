<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417115350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout montant total hors TVA + montant TVA';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article ADD montant_total_hors_tva INT NOT NULL, ADD montant_tva INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article DROP montant_total_hors_tva, DROP montant_tva');
    }
}
