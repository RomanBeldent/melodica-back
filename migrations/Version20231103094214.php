<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103094214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band_tag (band_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_EBC7F13C49ABEB17 (band_id), INDEX IDX_EBC7F13CBAD26311 (tag_id), PRIMARY KEY(band_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band_tag ADD CONSTRAINT FK_EBC7F13C49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_tag ADD CONSTRAINT FK_EBC7F13CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_band DROP FOREIGN KEY FK_A6D01D5DBAD26311');
        $this->addSql('ALTER TABLE tag_band DROP FOREIGN KEY FK_A6D01D5D49ABEB17');
        $this->addSql('DROP TABLE user_test');
        $this->addSql('DROP TABLE tag_band');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_test (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_A2FE32C5E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag_band (tag_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_A6D01D5DBAD26311 (tag_id), INDEX IDX_A6D01D5D49ABEB17 (band_id), PRIMARY KEY(tag_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tag_band ADD CONSTRAINT FK_A6D01D5DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_band ADD CONSTRAINT FK_A6D01D5D49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_tag DROP FOREIGN KEY FK_EBC7F13C49ABEB17');
        $this->addSql('ALTER TABLE band_tag DROP FOREIGN KEY FK_EBC7F13CBAD26311');
        $this->addSql('DROP TABLE band_tag');
    }
}
