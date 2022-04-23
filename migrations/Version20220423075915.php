<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423075915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'changement PDF Event->TraductionEvent + Newsletter->TraductionNewsletter';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP document_pdf, DROP updated_at');
        $this->addSql('ALTER TABLE newsletter DROP document_pdf, DROP updated_at');
        $this->addSql('ALTER TABLE traduction_event ADD document_pdf VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE traduction_newsletter ADD document_pdf VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD document_pdf VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE newsletter ADD document_pdf VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE traduction_event DROP document_pdf, DROP updated_at');
        $this->addSql('ALTER TABLE traduction_newsletter DROP document_pdf, DROP updated_at');
    }
}
