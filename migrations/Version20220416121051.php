<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416121051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-TypeEvent';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_type_event ADD langue_id INT NOT NULL, ADD type_event_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_type_event ADD CONSTRAINT FK_D5873BE62AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_type_event ADD CONSTRAINT FK_D5873BE6BC08CF77 FOREIGN KEY (type_event_id) REFERENCES type_event (id)');
        $this->addSql('CREATE INDEX IDX_D5873BE62AADBACD ON traduction_type_event (langue_id)');
        $this->addSql('CREATE INDEX IDX_D5873BE6BC08CF77 ON traduction_type_event (type_event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_type_event DROP FOREIGN KEY FK_D5873BE62AADBACD');
        $this->addSql('ALTER TABLE traduction_type_event DROP FOREIGN KEY FK_D5873BE6BC08CF77');
        $this->addSql('DROP INDEX IDX_D5873BE62AADBACD ON traduction_type_event');
        $this->addSql('DROP INDEX IDX_D5873BE6BC08CF77 ON traduction_type_event');
        $this->addSql('ALTER TABLE traduction_type_event DROP langue_id, DROP type_event_id');
    }
}
