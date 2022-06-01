<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601085159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création table TraductionNewsletterCategorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_newsletter_categorie (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_EE67D4F82AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD CONSTRAINT FK_EE67D4F82AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_newsletter_categorie');
    }
}
