<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601084746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création table NewsletterCategorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE newsletter_categorie (id INT AUTO_INCREMENT NOT NULL, nom_backend VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_categorie_utilisateur (newsletter_categorie_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_BB54390AB718D653 (newsletter_categorie_id), INDEX IDX_BB54390AFB88E14F (utilisateur_id), PRIMARY KEY(newsletter_categorie_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE newsletter_categorie_utilisateur ADD CONSTRAINT FK_BB54390AB718D653 FOREIGN KEY (newsletter_categorie_id) REFERENCES newsletter_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_categorie_utilisateur ADD CONSTRAINT FK_BB54390AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter_categorie_utilisateur DROP FOREIGN KEY FK_BB54390AB718D653');
        $this->addSql('DROP TABLE newsletter_categorie');
        $this->addSql('DROP TABLE newsletter_categorie_utilisateur');
    }
}
