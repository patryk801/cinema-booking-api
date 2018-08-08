<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180622000143 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE auditoriums (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, genre_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, cast VARCHAR(255) DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, age_restrictions VARCHAR(255) DEFAULT NULL, release_date DATETIME NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, trailer_youtube_url VARCHAR(255) DEFAULT NULL, INDEX IDX_C61EED304296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, screening_id INT DEFAULT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_4DA23970F5295D (screening_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations_seats (reservation_id INT NOT NULL, seat_id INT NOT NULL, INDEX IDX_7536A1BFB83297E7 (reservation_id), INDEX IDX_7536A1BFC1DAFE35 (seat_id), PRIMARY KEY(reservation_id, seat_id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screenings (id INT AUTO_INCREMENT NOT NULL, movie_id INT DEFAULT NULL, auditorium_id INT DEFAULT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_350DCAA38F93B6FC (movie_id), INDEX IDX_350DCAA33CF19AA0 (auditorium_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seats (id INT AUTO_INCREMENT NOT NULL, auditorium_id INT DEFAULT NULL, name VARCHAR(3) NOT NULL, row VARCHAR(3) NOT NULL, INDEX IDX_BFE257503CF19AA0 (auditorium_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED304296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23970F5295D FOREIGN KEY (screening_id) REFERENCES screenings (id)');
        $this->addSql('ALTER TABLE reservations_seats ADD CONSTRAINT FK_7536A1BFB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE reservations_seats ADD CONSTRAINT FK_7536A1BFC1DAFE35 FOREIGN KEY (seat_id) REFERENCES seats (id)');
        $this->addSql('ALTER TABLE screenings ADD CONSTRAINT FK_350DCAA38F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE screenings ADD CONSTRAINT FK_350DCAA33CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditoriums (id)');
        $this->addSql('ALTER TABLE seats ADD CONSTRAINT FK_BFE257503CF19AA0 FOREIGN KEY (auditorium_id) REFERENCES auditoriums (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE screenings DROP FOREIGN KEY FK_350DCAA33CF19AA0');
        $this->addSql('ALTER TABLE seats DROP FOREIGN KEY FK_BFE257503CF19AA0');
        $this->addSql('ALTER TABLE screenings DROP FOREIGN KEY FK_350DCAA38F93B6FC');
        $this->addSql('ALTER TABLE reservations_seats DROP FOREIGN KEY FK_7536A1BFB83297E7');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23970F5295D');
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED304296D31F');
        $this->addSql('ALTER TABLE reservations_seats DROP FOREIGN KEY FK_7536A1BFC1DAFE35');
        $this->addSql('DROP TABLE auditoriums');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE reservations_seats');
        $this->addSql('DROP TABLE screenings');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE seats');
    }
}
