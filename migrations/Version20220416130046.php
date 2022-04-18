<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416130046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Image-PositionImage';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD position_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F198277DA FOREIGN KEY (position_image_id) REFERENCES position_image (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F198277DA ON image (position_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F198277DA');
        $this->addSql('DROP INDEX IDX_C53D045F198277DA ON image');
        $this->addSql('ALTER TABLE image DROP position_image_id');
    }
}
