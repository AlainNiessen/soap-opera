<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831102456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'on delete cascade evaluation - article / evaluation - utilisateur';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5757294869C');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575FB88E14F');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5757294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5757294869C');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575FB88E14F');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5757294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }
}
