<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417133502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Odeur';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_odeur (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, odeur_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_CEF03E8C2AADBACD (langue_id), INDEX IDX_CEF03E8C222D80EB (odeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_odeur ADD CONSTRAINT FK_CEF03E8C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_odeur ADD CONSTRAINT FK_CEF03E8C222D80EB FOREIGN KEY (odeur_id) REFERENCES odeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_odeur');
    }
}
