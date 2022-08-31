<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831090540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changement onDelete = cascade';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E22DB1917');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E22DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E22DB1917');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E22DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
    }
}
