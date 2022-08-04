<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804144825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adaptation table partenaire => points de vente / restructuration des entités';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F98DE13AC');
        $this->addSql('ALTER TABLE partenaire_categorie DROP FOREIGN KEY FK_DD01450698DE13AC');
        $this->addSql('ALTER TABLE traduction_partenaire DROP FOREIGN KEY FK_D2DA15C598DE13AC');
        $this->addSql('CREATE TABLE point_de_vente (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C9182F7B4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE point_de_vente ADD CONSTRAINT FK_C9182F7B4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE partenaire_categorie');
        $this->addSql('DROP TABLE traduction_partenaire');
        $this->addSql('DROP INDEX IDX_C53D045F98DE13AC ON image');
        $this->addSql('ALTER TABLE image CHANGE partenaire_id point_de_vente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3F95E273 FOREIGN KEY (point_de_vente_id) REFERENCES point_de_vente (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F3F95E273 ON image (point_de_vente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3F95E273');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_32FFA3734DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE partenaire_categorie (partenaire_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_DD01450698DE13AC (partenaire_id), INDEX IDX_DD014506BCF5E72D (categorie_id), PRIMARY KEY(partenaire_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traduction_partenaire (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, partenaire_id INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D2DA15C598DE13AC (partenaire_id), INDEX IDX_D2DA15C52AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA3734DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE partenaire_categorie ADD CONSTRAINT FK_DD01450698DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_categorie ADD CONSTRAINT FK_DD014506BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_partenaire ADD CONSTRAINT FK_D2DA15C52AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_partenaire ADD CONSTRAINT FK_D2DA15C598DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('DROP TABLE point_de_vente');
        $this->addSql('DROP INDEX IDX_C53D045F3F95E273 ON image');
        $this->addSql('ALTER TABLE image CHANGE point_de_vente_id partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F98DE13AC ON image (partenaire_id)');
    }
}
