<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416122657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Adresse';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_adresse ADD langue_id INT NOT NULL, ADD adresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_adresse ADD CONSTRAINT FK_FD60A4662AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_adresse ADD CONSTRAINT FK_FD60A4664DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_FD60A4662AADBACD ON traduction_adresse (langue_id)');
        $this->addSql('CREATE INDEX IDX_FD60A4664DE7DC5C ON traduction_adresse (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_adresse DROP FOREIGN KEY FK_FD60A4662AADBACD');
        $this->addSql('ALTER TABLE traduction_adresse DROP FOREIGN KEY FK_FD60A4664DE7DC5C');
        $this->addSql('DROP INDEX IDX_FD60A4662AADBACD ON traduction_adresse');
        $this->addSql('DROP INDEX IDX_FD60A4664DE7DC5C ON traduction_adresse');
        $this->addSql('ALTER TABLE traduction_adresse DROP langue_id, DROP adresse_id');
    }
}
