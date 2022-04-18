<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416121555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Newsletter';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_newsletter ADD langue_id INT NOT NULL, ADD newsletter_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E22DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('CREATE INDEX IDX_9EA0337E2AADBACD ON traduction_newsletter (langue_id)');
        $this->addSql('CREATE INDEX IDX_9EA0337E22DB1917 ON traduction_newsletter (newsletter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E2AADBACD');
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E22DB1917');
        $this->addSql('DROP INDEX IDX_9EA0337E2AADBACD ON traduction_newsletter');
        $this->addSql('DROP INDEX IDX_9EA0337E22DB1917 ON traduction_newsletter');
        $this->addSql('ALTER TABLE traduction_newsletter DROP langue_id, DROP newsletter_id');
    }
}
