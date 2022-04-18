<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417134446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation article-ingrédientSupplémentaire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_ingredient_supplementaire (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, ingredient_supplementaire_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_5766044C2AADBACD (langue_id), INDEX IDX_5766044C491BCAD2 (ingredient_supplementaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire ADD CONSTRAINT FK_5766044C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire ADD CONSTRAINT FK_5766044C491BCAD2 FOREIGN KEY (ingredient_supplementaire_id) REFERENCES ingredient_supplementaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_ingredient_supplementaire');
    }
}
