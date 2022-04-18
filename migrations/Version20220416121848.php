<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416121848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Partenaire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_partenaire ADD langue_id INT NOT NULL, ADD partenaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_partenaire ADD CONSTRAINT FK_D2DA15C52AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_partenaire ADD CONSTRAINT FK_D2DA15C598DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_D2DA15C52AADBACD ON traduction_partenaire (langue_id)');
        $this->addSql('CREATE INDEX IDX_D2DA15C598DE13AC ON traduction_partenaire (partenaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_partenaire DROP FOREIGN KEY FK_D2DA15C52AADBACD');
        $this->addSql('ALTER TABLE traduction_partenaire DROP FOREIGN KEY FK_D2DA15C598DE13AC');
        $this->addSql('DROP INDEX IDX_D2DA15C52AADBACD ON traduction_partenaire');
        $this->addSql('DROP INDEX IDX_D2DA15C598DE13AC ON traduction_partenaire');
        $this->addSql('ALTER TABLE traduction_partenaire DROP langue_id, DROP partenaire_id');
    }
}
