<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415132000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Adresse-Partenaire + Adresse-Utilisateur(home+deliver)';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire ADD adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA3734DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_32FFA3734DE7DC5C ON partenaire (adresse_id)');
        $this->addSql('ALTER TABLE utilisateur ADD adresse_home_id INT NOT NULL, ADD adresse_deliver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B386D37703 FOREIGN KEY (adresse_home_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3F9AA6F6 FOREIGN KEY (adresse_deliver_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B386D37703 ON utilisateur (adresse_home_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3F9AA6F6 ON utilisateur (adresse_deliver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA3734DE7DC5C');
        $this->addSql('DROP INDEX IDX_32FFA3734DE7DC5C ON partenaire');
        $this->addSql('ALTER TABLE partenaire DROP adresse_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B386D37703');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3F9AA6F6');
        $this->addSql('DROP INDEX IDX_1D1C63B386D37703 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3F9AA6F6 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP adresse_home_id, DROP adresse_deliver_id');
    }
}
