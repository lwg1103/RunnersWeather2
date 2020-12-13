<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213161734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_api_access (id INT AUTO_INCREMENT NOT NULL, api_key VARCHAR(32) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_27F9AA38C912ED9D (api_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD api_access_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649323EC2B4 FOREIGN KEY (api_access_id) REFERENCES user_api_access (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649323EC2B4 ON user (api_access_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649323EC2B4');
        $this->addSql('DROP TABLE user_api_access');
        $this->addSql('DROP INDEX UNIQ_8D93D649323EC2B4 ON user');
        $this->addSql('ALTER TABLE user DROP api_access_id, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
