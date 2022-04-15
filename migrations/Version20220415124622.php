<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415124622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création table Promotion + relation promotion - article + relation promotion - catégorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, date_affichage_start DATETIME NOT NULL, date_affichage_end DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, pourcentage INT DEFAULT NULL, INDEX IDX_C11D7DD17294869C (article_id), INDEX IDX_C11D7DD1BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD17294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promotion');
    }
}
