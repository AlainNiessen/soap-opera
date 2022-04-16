<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416122054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Promotion';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_promotion ADD langue_id INT NOT NULL, ADD promotion_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_promotion ADD CONSTRAINT FK_3142D5DB2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_promotion ADD CONSTRAINT FK_3142D5DB139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_3142D5DB2AADBACD ON traduction_promotion (langue_id)');
        $this->addSql('CREATE INDEX IDX_3142D5DB139DF194 ON traduction_promotion (promotion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_promotion DROP FOREIGN KEY FK_3142D5DB2AADBACD');
        $this->addSql('ALTER TABLE traduction_promotion DROP FOREIGN KEY FK_3142D5DB139DF194');
        $this->addSql('DROP INDEX IDX_3142D5DB2AADBACD ON traduction_promotion');
        $this->addSql('DROP INDEX IDX_3142D5DB139DF194 ON traduction_promotion');
        $this->addSql('ALTER TABLE traduction_promotion DROP langue_id, DROP promotion_id');
    }
}
