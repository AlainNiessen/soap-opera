<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416125605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Image avec les entités';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD categorie_id INT DEFAULT NULL, ADD article_id INT DEFAULT NULL, ADD partenaire_id INT DEFAULT NULL, ADD event_id INT DEFAULT NULL, ADD layout_website TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FBCF5E72D ON image (categorie_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F7294869C ON image (article_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F98DE13AC ON image (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F71F7E88B ON image (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBCF5E72D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7294869C');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F98DE13AC');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F71F7E88B');
        $this->addSql('DROP INDEX IDX_C53D045FBCF5E72D ON image');
        $this->addSql('DROP INDEX IDX_C53D045F7294869C ON image');
        $this->addSql('DROP INDEX IDX_C53D045F98DE13AC ON image');
        $this->addSql('DROP INDEX IDX_C53D045F71F7E88B ON image');
        $this->addSql('ALTER TABLE image DROP categorie_id, DROP article_id, DROP partenaire_id, DROP event_id, DROP layout_website');
    }
}
