<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601091222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout à la table Newsletter le statutEnvoie + NewsletterCategorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter ADD newsletter_categories_id INT NOT NULL, ADD statut_envoie TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C815A4A5BD FOREIGN KEY (newsletter_categories_id) REFERENCES newsletter_categorie (id)');
        $this->addSql('CREATE INDEX IDX_7E8585C815A4A5BD ON newsletter (newsletter_categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C815A4A5BD');
        $this->addSql('DROP INDEX IDX_7E8585C815A4A5BD ON newsletter');
        $this->addSql('ALTER TABLE newsletter DROP newsletter_categories_id, DROP statut_envoie');
    }
}
