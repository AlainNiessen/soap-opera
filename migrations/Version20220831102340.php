<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831102340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'on delete cascade detailcommande - article / detailcommande - fatcure';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article DROP FOREIGN KEY FK_D68E2DEA7294869C');
        $this->addSql('ALTER TABLE detail_commande_article DROP FOREIGN KEY FK_D68E2DEA7F2DEE08');
        $this->addSql('ALTER TABLE detail_commande_article ADD CONSTRAINT FK_D68E2DEA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_commande_article ADD CONSTRAINT FK_D68E2DEA7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article DROP FOREIGN KEY FK_D68E2DEA7F2DEE08');
        $this->addSql('ALTER TABLE detail_commande_article DROP FOREIGN KEY FK_D68E2DEA7294869C');
        $this->addSql('ALTER TABLE detail_commande_article ADD CONSTRAINT FK_D68E2DEA7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE detail_commande_article ADD CONSTRAINT FK_D68E2DEA7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }
}
