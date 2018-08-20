<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180814184753 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movies ADD image_id INT DEFAULT NULL, DROP cover_image');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED303DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C61EED303DA5256D ON movies (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED303DA5256D');
        $this->addSql('DROP INDEX UNIQ_C61EED303DA5256D ON movies');
        $this->addSql('ALTER TABLE movies ADD cover_image VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP image_id');
    }
}
