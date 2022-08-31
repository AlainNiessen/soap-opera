<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831102821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'on delete cascade newsletter - catnewsletter';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C815A4A5BD');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C815A4A5BD FOREIGN KEY (newsletter_categories_id) REFERENCES newsletter_categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C815A4A5BD');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C815A4A5BD FOREIGN KEY (newsletter_categories_id) REFERENCES newsletter_categorie (id)');
    }
}
