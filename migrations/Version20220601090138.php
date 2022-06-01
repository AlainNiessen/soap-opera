<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601090138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout à la table TraductionNewsletterCategorie le NewsletterCategorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD newsletter_categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD CONSTRAINT FK_EE67D4F815A4A5BD FOREIGN KEY (newsletter_categories_id) REFERENCES newsletter_categorie (id)');
        $this->addSql('CREATE INDEX IDX_EE67D4F815A4A5BD ON traduction_newsletter_categorie (newsletter_categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_newsletter_categorie DROP FOREIGN KEY FK_EE67D4F815A4A5BD');
        $this->addSql('DROP INDEX IDX_EE67D4F815A4A5BD ON traduction_newsletter_categorie');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie DROP newsletter_categories_id');
    }
}
