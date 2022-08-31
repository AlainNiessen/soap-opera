<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831101722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'on delete cascade pour les traductions';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_article DROP FOREIGN KEY FK_3C05A2162AADBACD');
        $this->addSql('ALTER TABLE traduction_article DROP FOREIGN KEY FK_3C05A2167294869C');
        $this->addSql('ALTER TABLE traduction_article ADD CONSTRAINT FK_3C05A2162AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_article ADD CONSTRAINT FK_3C05A2167294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_beurre DROP FOREIGN KEY FK_DFB23E1B2AADBACD');
        $this->addSql('ALTER TABLE traduction_beurre DROP FOREIGN KEY FK_DFB23E1BE2C7E8A9');
        $this->addSql('ALTER TABLE traduction_beurre ADD CONSTRAINT FK_DFB23E1B2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_beurre ADD CONSTRAINT FK_DFB23E1BE2C7E8A9 FOREIGN KEY (beurre_id) REFERENCES beurre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_categorie DROP FOREIGN KEY FK_B9227E3E2AADBACD');
        $this->addSql('ALTER TABLE traduction_categorie DROP FOREIGN KEY FK_B9227E3EBCF5E72D');
        $this->addSql('ALTER TABLE traduction_categorie ADD CONSTRAINT FK_B9227E3E2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_categorie ADD CONSTRAINT FK_B9227E3EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_huile DROP FOREIGN KEY FK_85BC07DD2AADBACD');
        $this->addSql('ALTER TABLE traduction_huile DROP FOREIGN KEY FK_85BC07DD3EBD4426');
        $this->addSql('ALTER TABLE traduction_huile ADD CONSTRAINT FK_85BC07DD2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_huile ADD CONSTRAINT FK_85BC07DD3EBD4426 FOREIGN KEY (huile_id) REFERENCES huile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_huile_essentiel DROP FOREIGN KEY FK_562960202AADBACD');
        $this->addSql('ALTER TABLE traduction_huile_essentiel DROP FOREIGN KEY FK_5629602055CA86AD');
        $this->addSql('ALTER TABLE traduction_huile_essentiel ADD CONSTRAINT FK_562960202AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_huile_essentiel ADD CONSTRAINT FK_5629602055CA86AD FOREIGN KEY (huile_essentiel_id) REFERENCES huile_essentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire DROP FOREIGN KEY FK_5766044C2AADBACD');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire DROP FOREIGN KEY FK_5766044C491BCAD2');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire ADD CONSTRAINT FK_5766044C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire ADD CONSTRAINT FK_5766044C491BCAD2 FOREIGN KEY (ingredient_supplementaire_id) REFERENCES ingredient_supplementaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E22DB1917');
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E2AADBACD');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E22DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie DROP FOREIGN KEY FK_EE67D4F815A4A5BD');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie DROP FOREIGN KEY FK_EE67D4F82AADBACD');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD CONSTRAINT FK_EE67D4F815A4A5BD FOREIGN KEY (newsletter_categories_id) REFERENCES newsletter_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD CONSTRAINT FK_EE67D4F82AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_odeur DROP FOREIGN KEY FK_CEF03E8C222D80EB');
        $this->addSql('ALTER TABLE traduction_odeur DROP FOREIGN KEY FK_CEF03E8C2AADBACD');
        $this->addSql('ALTER TABLE traduction_odeur ADD CONSTRAINT FK_CEF03E8C222D80EB FOREIGN KEY (odeur_id) REFERENCES odeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_odeur ADD CONSTRAINT FK_CEF03E8C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_point_de_vente DROP FOREIGN KEY FK_782B8E002AADBACD');
        $this->addSql('ALTER TABLE traduction_point_de_vente DROP FOREIGN KEY FK_782B8E003F95E273');
        $this->addSql('ALTER TABLE traduction_point_de_vente ADD CONSTRAINT FK_782B8E002AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_point_de_vente ADD CONSTRAINT FK_782B8E003F95E273 FOREIGN KEY (point_de_vente_id) REFERENCES point_de_vente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_promotion DROP FOREIGN KEY FK_3142D5DB139DF194');
        $this->addSql('ALTER TABLE traduction_promotion DROP FOREIGN KEY FK_3142D5DB2AADBACD');
        $this->addSql('ALTER TABLE traduction_promotion ADD CONSTRAINT FK_3142D5DB139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traduction_promotion ADD CONSTRAINT FK_3142D5DB2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traduction_article DROP FOREIGN KEY FK_3C05A2162AADBACD');
        $this->addSql('ALTER TABLE traduction_article DROP FOREIGN KEY FK_3C05A2167294869C');
        $this->addSql('ALTER TABLE traduction_article ADD CONSTRAINT FK_3C05A2162AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_article ADD CONSTRAINT FK_3C05A2167294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE traduction_beurre DROP FOREIGN KEY FK_DFB23E1B2AADBACD');
        $this->addSql('ALTER TABLE traduction_beurre DROP FOREIGN KEY FK_DFB23E1BE2C7E8A9');
        $this->addSql('ALTER TABLE traduction_beurre ADD CONSTRAINT FK_DFB23E1B2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_beurre ADD CONSTRAINT FK_DFB23E1BE2C7E8A9 FOREIGN KEY (beurre_id) REFERENCES beurre (id)');
        $this->addSql('ALTER TABLE traduction_categorie DROP FOREIGN KEY FK_B9227E3E2AADBACD');
        $this->addSql('ALTER TABLE traduction_categorie DROP FOREIGN KEY FK_B9227E3EBCF5E72D');
        $this->addSql('ALTER TABLE traduction_categorie ADD CONSTRAINT FK_B9227E3E2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_categorie ADD CONSTRAINT FK_B9227E3EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE traduction_huile DROP FOREIGN KEY FK_85BC07DD2AADBACD');
        $this->addSql('ALTER TABLE traduction_huile DROP FOREIGN KEY FK_85BC07DD3EBD4426');
        $this->addSql('ALTER TABLE traduction_huile ADD CONSTRAINT FK_85BC07DD2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_huile ADD CONSTRAINT FK_85BC07DD3EBD4426 FOREIGN KEY (huile_id) REFERENCES huile (id)');
        $this->addSql('ALTER TABLE traduction_huile_essentiel DROP FOREIGN KEY FK_562960202AADBACD');
        $this->addSql('ALTER TABLE traduction_huile_essentiel DROP FOREIGN KEY FK_5629602055CA86AD');
        $this->addSql('ALTER TABLE traduction_huile_essentiel ADD CONSTRAINT FK_562960202AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_huile_essentiel ADD CONSTRAINT FK_5629602055CA86AD FOREIGN KEY (huile_essentiel_id) REFERENCES huile_essentiel (id)');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire DROP FOREIGN KEY FK_5766044C2AADBACD');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire DROP FOREIGN KEY FK_5766044C491BCAD2');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire ADD CONSTRAINT FK_5766044C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_ingredient_supplementaire ADD CONSTRAINT FK_5766044C491BCAD2 FOREIGN KEY (ingredient_supplementaire_id) REFERENCES ingredient_supplementaire (id)');
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E2AADBACD');
        $this->addSql('ALTER TABLE traduction_newsletter DROP FOREIGN KEY FK_9EA0337E22DB1917');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_newsletter ADD CONSTRAINT FK_9EA0337E22DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie DROP FOREIGN KEY FK_EE67D4F82AADBACD');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie DROP FOREIGN KEY FK_EE67D4F815A4A5BD');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD CONSTRAINT FK_EE67D4F82AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_newsletter_categorie ADD CONSTRAINT FK_EE67D4F815A4A5BD FOREIGN KEY (newsletter_categories_id) REFERENCES newsletter_categorie (id)');
        $this->addSql('ALTER TABLE traduction_odeur DROP FOREIGN KEY FK_CEF03E8C2AADBACD');
        $this->addSql('ALTER TABLE traduction_odeur DROP FOREIGN KEY FK_CEF03E8C222D80EB');
        $this->addSql('ALTER TABLE traduction_odeur ADD CONSTRAINT FK_CEF03E8C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_odeur ADD CONSTRAINT FK_CEF03E8C222D80EB FOREIGN KEY (odeur_id) REFERENCES odeur (id)');
        $this->addSql('ALTER TABLE traduction_point_de_vente DROP FOREIGN KEY FK_782B8E002AADBACD');
        $this->addSql('ALTER TABLE traduction_point_de_vente DROP FOREIGN KEY FK_782B8E003F95E273');
        $this->addSql('ALTER TABLE traduction_point_de_vente ADD CONSTRAINT FK_782B8E002AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_point_de_vente ADD CONSTRAINT FK_782B8E003F95E273 FOREIGN KEY (point_de_vente_id) REFERENCES point_de_vente (id)');
        $this->addSql('ALTER TABLE traduction_promotion DROP FOREIGN KEY FK_3142D5DB2AADBACD');
        $this->addSql('ALTER TABLE traduction_promotion DROP FOREIGN KEY FK_3142D5DB139DF194');
        $this->addSql('ALTER TABLE traduction_promotion ADD CONSTRAINT FK_3142D5DB2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE traduction_promotion ADD CONSTRAINT FK_3142D5DB139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
    }
}
