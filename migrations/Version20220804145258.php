<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804145258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création Traduction point de vente';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_point_de_vente (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, point_de_vente_id INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_782B8E002AADBACD (langue_id), INDEX IDX_782B8E003F95E273 (point_de_vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_point_de_vente ADD CONSTRAINT FK_782B8E002AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_point_de_vente ADD CONSTRAINT FK_782B8E003F95E273 FOREIGN KEY (point_de_vente_id) REFERENCES point_de_vente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_point_de_vente');
    }
}
