<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416123054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Event';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_event ADD langue_id INT NOT NULL, ADD event_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_event ADD CONSTRAINT FK_3E05D7962AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_event ADD CONSTRAINT FK_3E05D79671F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_3E05D7962AADBACD ON traduction_event (langue_id)');
        $this->addSql('CREATE INDEX IDX_3E05D79671F7E88B ON traduction_event (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_event DROP FOREIGN KEY FK_3E05D7962AADBACD');
        $this->addSql('ALTER TABLE traduction_event DROP FOREIGN KEY FK_3E05D79671F7E88B');
        $this->addSql('DROP INDEX IDX_3E05D7962AADBACD ON traduction_event');
        $this->addSql('DROP INDEX IDX_3E05D79671F7E88B ON traduction_event');
        $this->addSql('ALTER TABLE traduction_event DROP langue_id, DROP event_id');
    }
}
