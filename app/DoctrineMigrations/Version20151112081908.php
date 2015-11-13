<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151112081908 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE Playlist ADD COLUMN UpdatedAt DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__Playlist AS SELECT PlaylistId, Name FROM Playlist');
        $this->addSql('DROP TABLE Playlist');
        $this->addSql('CREATE TABLE Playlist (PlaylistId INTEGER NOT NULL, Name VARCHAR(120) DEFAULT NULL, PRIMARY KEY(PlaylistId))');
        $this->addSql('INSERT INTO Playlist (PlaylistId, Name) SELECT PlaylistId, Name FROM __temp__Playlist');
        $this->addSql('DROP TABLE __temp__Playlist');
        $this->addSql('CREATE UNIQUE INDEX IPK_Playlist ON Playlist (PlaylistId)');
    }
}
