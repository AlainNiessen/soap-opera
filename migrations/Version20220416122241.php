<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416122241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Langue-Article';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_article ADD langue_id INT NOT NULL, ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_article ADD CONSTRAINT FK_3C05A2162AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_article ADD CONSTRAINT FK_3C05A2167294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_3C05A2162AADBACD ON traduction_article (langue_id)');
        $this->addSql('CREATE INDEX IDX_3C05A2167294869C ON traduction_article (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_article DROP FOREIGN KEY FK_3C05A2162AADBACD');
        $this->addSql('ALTER TABLE traduction_article DROP FOREIGN KEY FK_3C05A2167294869C');
        $this->addSql('DROP INDEX IDX_3C05A2162AADBACD ON traduction_article');
        $this->addSql('DROP INDEX IDX_3C05A2167294869C ON traduction_article');
        $this->addSql('ALTER TABLE traduction_article DROP langue_id, DROP article_id');
    }
}
