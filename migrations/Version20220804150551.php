<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804150551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete du EVENT - TYPEEVENT - TRADUCTIONEVENT - TRADUCTIONTYPEEVENT - RESERVATION';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F71F7E88B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571F7E88B');
        $this->addSql('ALTER TABLE traduction_event DROP FOREIGN KEY FK_3E05D79671F7E88B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7BC08CF77');
        $this->addSql('ALTER TABLE traduction_type_event DROP FOREIGN KEY FK_D5873BE6BC08CF77');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE traduction_event');
        $this->addSql('DROP TABLE traduction_type_event');
        $this->addSql('DROP TABLE type_event');
        $this->addSql('DROP INDEX IDX_C53D045F71F7E88B ON image');
        $this->addSql('ALTER TABLE image DROP event_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, type_event_id INT NOT NULL, date_affichage_start DATETIME NOT NULL, date_affichage_end DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, nombre_limit INT NOT NULL, montant_hors_tva DOUBLE PRECISION NOT NULL, taux_tva DOUBLE PRECISION NOT NULL, nom_backend VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3BAE0AA7BC08CF77 (type_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, facture_id INT NOT NULL, date_reservation DATETIME NOT NULL, montant_total_hors_tva DOUBLE PRECISION NOT NULL, montant_tva DOUBLE PRECISION NOT NULL, montant_total DOUBLE PRECISION NOT NULL, INDEX IDX_42C849557F2DEE08 (facture_id), INDEX IDX_42C8495571F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traduction_event (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, event_id INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, document_pdf VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL, INDEX IDX_3E05D79671F7E88B (event_id), INDEX IDX_3E05D7962AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traduction_type_event (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, type_event_id INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D5873BE6BC08CF77 (type_event_id), INDEX IDX_D5873BE62AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_event (id INT AUTO_INCREMENT NOT NULL, nom_backend VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7BC08CF77 FOREIGN KEY (type_event_id) REFERENCES type_event (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE traduction_event ADD CONSTRAINT FK_3E05D7962AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_event ADD CONSTRAINT FK_3E05D79671F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE traduction_type_event ADD CONSTRAINT FK_D5873BE62AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_type_event ADD CONSTRAINT FK_D5873BE6BC08CF77 FOREIGN KEY (type_event_id) REFERENCES type_event (id)');
        $this->addSql('ALTER TABLE image ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F71F7E88B ON image (event_id)');
    }
}
