<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527081128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adaptation Pourcentage de Int vers Float';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion CHANGE pourcentage pourcentage DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP facebook_id, DROP facebook_token');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion CHANGE pourcentage pourcentage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD facebook_id VARCHAR(255) DEFAULT NULL, ADD facebook_token VARCHAR(255) DEFAULT NULL');
    }
}
