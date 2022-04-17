<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417113835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout article au détail commande';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE detail_commande_article ADD CONSTRAINT FK_D68E2DEA7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_D68E2DEA7294869C ON detail_commande_article (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande_article DROP FOREIGN KEY FK_D68E2DEA7294869C');
        $this->addSql('DROP INDEX IDX_D68E2DEA7294869C ON detail_commande_article');
        $this->addSql('ALTER TABLE detail_commande_article DROP article_id');
    }
}
