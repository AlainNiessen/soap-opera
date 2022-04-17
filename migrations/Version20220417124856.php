<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417124856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation article-odeur';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD odeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66222D80EB FOREIGN KEY (odeur_id) REFERENCES odeur (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66222D80EB ON article (odeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66222D80EB');
        $this->addSql('DROP INDEX IDX_23A0E66222D80EB ON article');
        $this->addSql('ALTER TABLE article DROP odeur_id');
    }
}
