<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231109100617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band CHANGE picture picture_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event CHANGE picture picture_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organizer CHANGE picture picture_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP picture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE picture_filename picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organizer CHANGE picture_filename picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE band CHANGE picture_filename picture VARCHAR(255) DEFAULT NULL');
    }
}
