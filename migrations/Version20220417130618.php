<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417130618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation article-ingrédient supplémentaire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_ingredient_supplementaire (article_id INT NOT NULL, ingredient_supplementaire_id INT NOT NULL, INDEX IDX_3042176B7294869C (article_id), INDEX IDX_3042176B491BCAD2 (ingredient_supplementaire_id), PRIMARY KEY(article_id, ingredient_supplementaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_ingredient_supplementaire ADD CONSTRAINT FK_3042176B7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_ingredient_supplementaire ADD CONSTRAINT FK_3042176B491BCAD2 FOREIGN KEY (ingredient_supplementaire_id) REFERENCES ingredient_supplementaire (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_ingredient_supplementaire');
    }
}
