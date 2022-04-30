<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430090800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction coverList et coverDetail';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD cover_detail_article TINYINT(1) NOT NULL, CHANGE cover_article cover_list_article TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD cover_article TINYINT(1) NOT NULL, DROP cover_list_article, DROP cover_detail_article');
    }
}
