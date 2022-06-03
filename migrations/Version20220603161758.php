<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603161758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction of utilisateur - newsletterCategorie relation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_newsletter_categorie (utilisateur_id INT NOT NULL, newsletter_categorie_id INT NOT NULL, INDEX IDX_62A9FFBCFB88E14F (utilisateur_id), INDEX IDX_62A9FFBCB718D653 (newsletter_categorie_id), PRIMARY KEY(utilisateur_id, newsletter_categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_newsletter_categorie ADD CONSTRAINT FK_62A9FFBCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_newsletter_categorie ADD CONSTRAINT FK_62A9FFBCB718D653 FOREIGN KEY (newsletter_categorie_id) REFERENCES newsletter_categorie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE newsletter_categorie_utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE newsletter_categorie_utilisateur (newsletter_categorie_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_BB54390AB718D653 (newsletter_categorie_id), INDEX IDX_BB54390AFB88E14F (utilisateur_id), PRIMARY KEY(newsletter_categorie_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE newsletter_categorie_utilisateur ADD CONSTRAINT FK_BB54390AB718D653 FOREIGN KEY (newsletter_categorie_id) REFERENCES newsletter_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_categorie_utilisateur ADD CONSTRAINT FK_BB54390AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE utilisateur_newsletter_categorie');
    }
}
