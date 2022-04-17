<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417133727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Huile';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_huile (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, huile_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_85BC07DD2AADBACD (langue_id), INDEX IDX_85BC07DD3EBD4426 (huile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE traduction_huile ADD CONSTRAINT FK_85BC07DD2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_huile ADD CONSTRAINT FK_85BC07DD3EBD4426 FOREIGN KEY (huile_id) REFERENCES huile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_huile');
    }
}
