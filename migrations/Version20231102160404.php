<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102160404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band_user (band_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D6A5361249ABEB17 (band_id), INDEX IDX_D6A53612A76ED395 (user_id), PRIMARY KEY(band_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organizer_user (organizer_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9744570B876C4DDA (organizer_id), INDEX IDX_9744570BA76ED395 (user_id), PRIMARY KEY(organizer_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band_user ADD CONSTRAINT FK_D6A5361249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_user ADD CONSTRAINT FK_D6A53612A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organizer_user ADD CONSTRAINT FK_9744570B876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organizer_user ADD CONSTRAINT FK_9744570BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_band DROP FOREIGN KEY FK_325EEE22A76ED395');
        $this->addSql('ALTER TABLE user_band DROP FOREIGN KEY FK_325EEE2249ABEB17');
        $this->addSql('ALTER TABLE user_organizer DROP FOREIGN KEY FK_9934FC97876C4DDA');
        $this->addSql('ALTER TABLE user_organizer DROP FOREIGN KEY FK_9934FC97A76ED395');
        $this->addSql('DROP TABLE user_band');
        $this->addSql('DROP TABLE user_organizer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99D471735E237E06 ON organizer (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_band (user_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_325EEE2249ABEB17 (band_id), INDEX IDX_325EEE22A76ED395 (user_id), PRIMARY KEY(user_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_organizer (user_id INT NOT NULL, organizer_id INT NOT NULL, INDEX IDX_9934FC97A76ED395 (user_id), INDEX IDX_9934FC97876C4DDA (organizer_id), PRIMARY KEY(user_id, organizer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organizer ADD CONSTRAINT FK_9934FC97876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organizer ADD CONSTRAINT FK_9934FC97A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_user DROP FOREIGN KEY FK_D6A5361249ABEB17');
        $this->addSql('ALTER TABLE band_user DROP FOREIGN KEY FK_D6A53612A76ED395');
        $this->addSql('ALTER TABLE organizer_user DROP FOREIGN KEY FK_9744570B876C4DDA');
        $this->addSql('ALTER TABLE organizer_user DROP FOREIGN KEY FK_9744570BA76ED395');
        $this->addSql('DROP TABLE band_user');
        $this->addSql('DROP TABLE organizer_user');
        $this->addSql('DROP INDEX UNIQ_99D471735E237E06 ON organizer');
    }
}
