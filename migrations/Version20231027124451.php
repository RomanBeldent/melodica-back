<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027124451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, zipcode INT NOT NULL, city VARCHAR(85) NOT NULL, department INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, area INT NOT NULL, sample VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_48DFA2EBF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band_genre (band_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_7FB28D6449ABEB17 (band_id), INDEX IDX_7FB28D644296D31F (genre_id), PRIMARY KEY(band_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, date_start DATE NOT NULL, date_end DATE DEFAULT NULL, hour_start DATETIME NOT NULL, hour_end DATETIME DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3BAE0AA7F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_tag (event_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_1246725071F7E88B (event_id), INDEX IDX_12467250BAD26311 (tag_id), PRIMARY KEY(event_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_band (event_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_5714EE4071F7E88B (event_id), INDEX IDX_5714EE4049ABEB17 (band_id), PRIMARY KEY(event_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, band_id INT DEFAULT NULL, organizer_id INT DEFAULT NULL, INDEX IDX_68C58ED9A76ED395 (user_id), INDEX IDX_68C58ED949ABEB17 (band_id), INDEX IDX_68C58ED9876C4DDA (organizer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organizer (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, address_id INT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, website VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_99D47173C54C8C93 (type_id), UNIQUE INDEX UNIQ_99D47173F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_band (tag_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_A6D01D5DBAD26311 (tag_id), INDEX IDX_A6D01D5D49ABEB17 (band_id), PRIMARY KEY(tag_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, birthday DATE NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(50) NOT NULL, phone_number INT NOT NULL, picture VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_organizer (user_id INT NOT NULL, organizer_id INT NOT NULL, INDEX IDX_9934FC97A76ED395 (user_id), INDEX IDX_9934FC97876C4DDA (organizer_id), PRIMARY KEY(user_id, organizer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_band (user_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_325EEE22A76ED395 (user_id), INDEX IDX_325EEE2249ABEB17 (band_id), PRIMARY KEY(user_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EBF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE band_genre ADD CONSTRAINT FK_7FB28D6449ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_genre ADD CONSTRAINT FK_7FB28D644296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE event_tag ADD CONSTRAINT FK_1246725071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_tag ADD CONSTRAINT FK_12467250BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_band ADD CONSTRAINT FK_5714EE4071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_band ADD CONSTRAINT FK_5714EE4049ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id)');
        $this->addSql('ALTER TABLE organizer ADD CONSTRAINT FK_99D47173C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE organizer ADD CONSTRAINT FK_99D47173F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE tag_band ADD CONSTRAINT FK_A6D01D5DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_band ADD CONSTRAINT FK_A6D01D5D49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organizer ADD CONSTRAINT FK_9934FC97A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organizer ADD CONSTRAINT FK_9934FC97876C4DDA FOREIGN KEY (organizer_id) REFERENCES organizer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EBF5B7AF75');
        $this->addSql('ALTER TABLE band_genre DROP FOREIGN KEY FK_7FB28D6449ABEB17');
        $this->addSql('ALTER TABLE band_genre DROP FOREIGN KEY FK_7FB28D644296D31F');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7F5B7AF75');
        $this->addSql('ALTER TABLE event_tag DROP FOREIGN KEY FK_1246725071F7E88B');
        $this->addSql('ALTER TABLE event_tag DROP FOREIGN KEY FK_12467250BAD26311');
        $this->addSql('ALTER TABLE event_band DROP FOREIGN KEY FK_5714EE4071F7E88B');
        $this->addSql('ALTER TABLE event_band DROP FOREIGN KEY FK_5714EE4049ABEB17');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED949ABEB17');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9876C4DDA');
        $this->addSql('ALTER TABLE organizer DROP FOREIGN KEY FK_99D47173C54C8C93');
        $this->addSql('ALTER TABLE organizer DROP FOREIGN KEY FK_99D47173F5B7AF75');
        $this->addSql('ALTER TABLE tag_band DROP FOREIGN KEY FK_A6D01D5DBAD26311');
        $this->addSql('ALTER TABLE tag_band DROP FOREIGN KEY FK_A6D01D5D49ABEB17');
        $this->addSql('ALTER TABLE user_organizer DROP FOREIGN KEY FK_9934FC97A76ED395');
        $this->addSql('ALTER TABLE user_organizer DROP FOREIGN KEY FK_9934FC97876C4DDA');
        $this->addSql('ALTER TABLE user_band DROP FOREIGN KEY FK_325EEE22A76ED395');
        $this->addSql('ALTER TABLE user_band DROP FOREIGN KEY FK_325EEE2249ABEB17');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE band_genre');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_tag');
        $this->addSql('DROP TABLE event_band');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE organizer');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_band');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_organizer');
        $this->addSql('DROP TABLE user_band');
    }
}
