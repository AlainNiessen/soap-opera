<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415125245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Partenaire - Catégorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaire_categorie (partenaire_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_DD01450698DE13AC (partenaire_id), INDEX IDX_DD014506BCF5E72D (categorie_id), PRIMARY KEY(partenaire_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaire_categorie ADD CONSTRAINT FK_DD01450698DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_categorie ADD CONSTRAINT FK_DD014506BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE partenaire_categorie');
    }
}
