<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220729123130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, nom_site VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, whatsapp VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, seuil_livraison DOUBLE PRECISION DEFAULT NULL, gestion_stock TINYINT(1) NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parametre');
    }
}
