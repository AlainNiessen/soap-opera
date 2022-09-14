<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913215900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout onDelete SET NULL';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66139DF194');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66139DF194');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
    }
}
