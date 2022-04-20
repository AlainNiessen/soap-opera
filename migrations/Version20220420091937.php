<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420091937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction table Adresse + Suppression table Traduction Adresse';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE traduction_adresse');
        $this->addSql('ALTER TABLE adresse ADD rue VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traduction_adresse (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, adresse_id INT NOT NULL, rue VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pays VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_FD60A4664DE7DC5C (adresse_id), INDEX IDX_FD60A4662AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE traduction_adresse ADD CONSTRAINT FK_FD60A4662AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_adresse ADD CONSTRAINT FK_FD60A4664DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE adresse DROP rue, DROP ville, DROP pays');
    }
}
