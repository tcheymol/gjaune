<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240807153211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, enabled, created_at, updated_at, disabled, validated FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, enabled BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, disabled BOOLEAN NOT NULL, validated BOOLEAN NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_F09F15A27E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO collective (id, enabled, created_at, updated_at, disabled, validated) SELECT id, enabled, created_at, updated_at, disabled, validated FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
        $this->addSql('CREATE INDEX IDX_F09F15A27E3C61F9 ON collective (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL COLLATE "BINARY", headers CLOB NOT NULL COLLATE "BINARY", queue_name VARCHAR(190) NOT NULL COLLATE "BINARY", created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__collective AS SELECT id, enabled, created_at, updated_at, disabled, validated FROM collective');
        $this->addSql('DROP TABLE collective');
        $this->addSql('CREATE TABLE collective (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, enabled BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, disabled BOOLEAN NOT NULL, validated BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO collective (id, enabled, created_at, updated_at, disabled, validated) SELECT id, enabled, created_at, updated_at, disabled, validated FROM __temp__collective');
        $this->addSql('DROP TABLE __temp__collective');
    }
}
