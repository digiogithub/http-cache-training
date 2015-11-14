<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151113175617 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IFK_TrackMediaTypeId');
        $this->addSql('DROP INDEX IFK_TrackGenreId');
        $this->addSql('DROP INDEX IFK_TrackAlbumId');
        $this->addSql('DROP INDEX IPK_Track');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Track AS SELECT TrackId, Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice FROM Track');
        $this->addSql('DROP TABLE Track');
        $this->addSql('CREATE TABLE Track (TrackId INTEGER NOT NULL, Name VARCHAR(200) NOT NULL COLLATE BINARY, AlbumId INTEGER DEFAULT NULL, MediaTypeId INTEGER DEFAULT NULL, GenreId INTEGER DEFAULT NULL, Composer VARCHAR(220) DEFAULT NULL COLLATE BINARY, Milliseconds INTEGER NOT NULL, Bytes INTEGER DEFAULT NULL, UnitPrice NUMERIC(10, 2) NOT NULL, UpdatedAt DATETIME DEFAULT NULL, PRIMARY KEY(TrackId), CONSTRAINT FK_1722D7A2945E136F FOREIGN KEY (AlbumId) REFERENCES Album (AlbumId) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1722D7A28FE5365C FOREIGN KEY (MediaTypeId) REFERENCES MediaType (MediaTypeId) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1722D7A286B5F39D FOREIGN KEY (GenreId) REFERENCES Genre (GenreId) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO Track (TrackId, Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice) SELECT TrackId, Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice FROM __temp__Track');
        $this->addSql('DROP TABLE __temp__Track');
        $this->addSql('CREATE INDEX IFK_TrackMediaTypeId ON Track (MediaTypeId)');
        $this->addSql('CREATE INDEX IFK_TrackGenreId ON Track (GenreId)');
        $this->addSql('CREATE INDEX IFK_TrackAlbumId ON Track (AlbumId)');
        $this->addSql('CREATE UNIQUE INDEX IPK_Track ON Track (TrackId)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IFK_TrackMediaTypeId');
        $this->addSql('DROP INDEX IFK_TrackGenreId');
        $this->addSql('DROP INDEX IFK_TrackAlbumId');
        $this->addSql('DROP INDEX IPK_Track');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Track AS SELECT TrackId, Name, Composer, Milliseconds, Bytes, UnitPrice, AlbumId, MediaTypeId, GenreId FROM Track');
        $this->addSql('DROP TABLE Track');
        $this->addSql('CREATE TABLE Track (TrackId INTEGER NOT NULL, Name VARCHAR(200) NOT NULL, Composer VARCHAR(220) DEFAULT NULL, Milliseconds INTEGER NOT NULL, Bytes INTEGER DEFAULT NULL, UnitPrice NUMERIC(10, 2) NOT NULL, AlbumId INTEGER DEFAULT NULL, MediaTypeId INTEGER NOT NULL, GenreId INTEGER DEFAULT NULL, PRIMARY KEY(TrackId))');
        $this->addSql('INSERT INTO Track (TrackId, Name, Composer, Milliseconds, Bytes, UnitPrice, AlbumId, MediaTypeId, GenreId) SELECT TrackId, Name, Composer, Milliseconds, Bytes, UnitPrice, AlbumId, MediaTypeId, GenreId FROM __temp__Track');
        $this->addSql('DROP TABLE __temp__Track');
        $this->addSql('CREATE INDEX IFK_TrackMediaTypeId ON Track (MediaTypeId)');
        $this->addSql('CREATE INDEX IFK_TrackGenreId ON Track (GenreId)');
        $this->addSql('CREATE INDEX IFK_TrackAlbumId ON Track (AlbumId)');
        $this->addSql('CREATE UNIQUE INDEX IPK_Track ON Track (TrackId)');
    }
}
