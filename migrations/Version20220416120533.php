<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416120533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation langue-categorie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_categorie ADD langue_id INT NOT NULL, ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_categorie ADD CONSTRAINT FK_B9227E3E2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_categorie ADD CONSTRAINT FK_B9227E3EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_B9227E3E2AADBACD ON traduction_categorie (langue_id)');
        $this->addSql('CREATE INDEX IDX_B9227E3EBCF5E72D ON traduction_categorie (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_categorie DROP FOREIGN KEY FK_B9227E3E2AADBACD');
        $this->addSql('ALTER TABLE traduction_categorie DROP FOREIGN KEY FK_B9227E3EBCF5E72D');
        $this->addSql('DROP INDEX IDX_B9227E3E2AADBACD ON traduction_categorie');
        $this->addSql('DROP INDEX IDX_B9227E3EBCF5E72D ON traduction_categorie');
        $this->addSql('ALTER TABLE traduction_categorie DROP langue_id, DROP categorie_id');
    }
}
