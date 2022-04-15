<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415134305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation DetailCommandeArticle-Facture';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE detail_commande_article ADD CONSTRAINT FK_D68E2DEA7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_D68E2DEA7F2DEE08 ON detail_commande_article (facture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article DROP FOREIGN KEY FK_D68E2DEA7F2DEE08');
        $this->addSql('DROP INDEX IDX_D68E2DEA7F2DEE08 ON detail_commande_article');
        $this->addSql('ALTER TABLE detail_commande_article DROP facture_id');
    }
}
