<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417133952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Huile essentiel';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_huile_essentiel (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, huile_essentiel_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_562960202AADBACD (langue_id), INDEX IDX_5629602055CA86AD (huile_essentiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_huile_essentiel ADD CONSTRAINT FK_562960202AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_huile_essentiel ADD CONSTRAINT FK_5629602055CA86AD FOREIGN KEY (huile_essentiel_id) REFERENCES huile_essentiel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_huile_essentiel');
    }
}
