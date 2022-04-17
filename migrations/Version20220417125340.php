<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417125340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation article-huile';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_huile (article_id INT NOT NULL, huile_id INT NOT NULL, INDEX IDX_F7A0A8FD7294869C (article_id), INDEX IDX_F7A0A8FD3EBD4426 (huile_id), PRIMARY KEY(article_id, huile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_huile ADD CONSTRAINT FK_F7A0A8FD7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_huile ADD CONSTRAINT FK_F7A0A8FD3EBD4426 FOREIGN KEY (huile_id) REFERENCES huile (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_huile');
    }
}
