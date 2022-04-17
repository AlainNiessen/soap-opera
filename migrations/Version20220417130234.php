<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417130234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation article-beurre';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_beurre (article_id INT NOT NULL, beurre_id INT NOT NULL, INDEX IDX_E4AE027C7294869C (article_id), INDEX IDX_E4AE027CE2C7E8A9 (beurre_id), PRIMARY KEY(article_id, beurre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_beurre ADD CONSTRAINT FK_E4AE027C7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_beurre ADD CONSTRAINT FK_E4AE027CE2C7E8A9 FOREIGN KEY (beurre_id) REFERENCES beurre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_beurre');
    }
}
