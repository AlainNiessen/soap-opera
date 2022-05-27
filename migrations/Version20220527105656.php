<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527105656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changement relations promotions-articles - promotions-categories';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6610007789');
        $this->addSql('DROP INDEX IDX_23A0E6610007789 ON article');
        $this->addSql('ALTER TABLE article CHANGE promotions_id promotion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66139DF194 ON article (promotion_id)');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD63410007789');
        $this->addSql('DROP INDEX IDX_497DD63410007789 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE promotions_id promotion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_497DD634139DF194 ON categorie (promotion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66139DF194');
        $this->addSql('DROP INDEX IDX_23A0E66139DF194 ON article');
        $this->addSql('ALTER TABLE article CHANGE promotion_id promotions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6610007789 FOREIGN KEY (promotions_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6610007789 ON article (promotions_id)');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634139DF194');
        $this->addSql('DROP INDEX IDX_497DD634139DF194 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE promotion_id promotions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD63410007789 FOREIGN KEY (promotions_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_497DD63410007789 ON categorie (promotions_id)');
    }
}
