<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417125808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation article-huileEssentiel';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_huile_essentiel (article_id INT NOT NULL, huile_essentiel_id INT NOT NULL, INDEX IDX_728ACBAB7294869C (article_id), INDEX IDX_728ACBAB55CA86AD (huile_essentiel_id), PRIMARY KEY(article_id, huile_essentiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_huile_essentiel ADD CONSTRAINT FK_728ACBAB7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_huile_essentiel ADD CONSTRAINT FK_728ACBAB55CA86AD FOREIGN KEY (huile_essentiel_id) REFERENCES huile_essentiel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_huile_essentiel');
    }
}
