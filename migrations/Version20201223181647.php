<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201223181647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_request_logs ADD user_id INT DEFAULT NULL, DROP user');
        $this->addSql('ALTER TABLE api_request_logs ADD CONSTRAINT FK_8542380BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8542380BA76ED395 ON api_request_logs (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_request_logs DROP FOREIGN KEY FK_8542380BA76ED395');
        $this->addSql('DROP INDEX IDX_8542380BA76ED395 ON api_request_logs');
        $this->addSql('ALTER TABLE api_request_logs ADD user INT NOT NULL, DROP user_id');
    }
}
