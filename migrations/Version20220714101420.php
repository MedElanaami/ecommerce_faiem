<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714101420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, type_reduction_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, courte_desc VARCHAR(255) NOT NULL, longue_desc VARCHAR(255) NOT NULL, prix_achat DOUBLE PRECISION DEFAULT NULL, prix_vente DOUBLE PRECISION NOT NULL, qte_stock INT NOT NULL, slug VARCHAR(255) NOT NULL, visibilite TINYINT(1) NOT NULL, favoris TINYINT(1) NOT NULL, reduction_applique TINYINT(1) NOT NULL, valeur_reduction DOUBLE PRECISION DEFAULT NULL, INDEX IDX_29A5EC27477F0A97 (type_reduction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27477F0A97 FOREIGN KEY (type_reduction_id) REFERENCES type_reduction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit');
    }
}
