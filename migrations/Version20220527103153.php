<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527103153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changement des relations promotions-articles + promotions-categories';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD promotions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6610007789 FOREIGN KEY (promotions_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6610007789 ON article (promotions_id)');
        $this->addSql('ALTER TABLE categorie ADD promotions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD63410007789 FOREIGN KEY (promotions_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_497DD63410007789 ON categorie (promotions_id)');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD17294869C');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1BCF5E72D');
        $this->addSql('DROP INDEX IDX_C11D7DD1BCF5E72D ON promotion');
        $this->addSql('DROP INDEX IDX_C11D7DD17294869C ON promotion');
        $this->addSql('ALTER TABLE promotion DROP article_id, DROP categorie_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6610007789');
        $this->addSql('DROP INDEX IDX_23A0E6610007789 ON article');
        $this->addSql('ALTER TABLE article DROP promotions_id');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD63410007789');
        $this->addSql('DROP INDEX IDX_497DD63410007789 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP promotions_id');
        $this->addSql('ALTER TABLE promotion ADD article_id INT DEFAULT NULL, ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD17294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1BCF5E72D ON promotion (categorie_id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD17294869C ON promotion (article_id)');
    }
}
