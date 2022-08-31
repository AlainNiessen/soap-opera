<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831104546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'on delete cascade image';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBCF5E72D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F198277DA');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7294869C');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3F95E273');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F198277DA FOREIGN KEY (position_image_id) REFERENCES position_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3F95E273 FOREIGN KEY (point_de_vente_id) REFERENCES point_de_vente (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBCF5E72D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7294869C');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F198277DA');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3F95E273');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F198277DA FOREIGN KEY (position_image_id) REFERENCES position_image (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3F95E273 FOREIGN KEY (point_de_vente_id) REFERENCES point_de_vente (id)');
    }
}
