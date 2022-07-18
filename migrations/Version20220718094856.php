<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718094856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribut (id INT AUTO_INCREMENT NOT NULL, caracteristique_id INT NOT NULL, valeur VARCHAR(255) NOT NULL, INDEX IDX_7AB8E85D1704EEB7 (caracteristique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_497DD634727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, ville_id INT NOT NULL, tel VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal INT DEFAULT NULL, INDEX IDX_C7440455A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, coupon_id INT DEFAULT NULL, status_id INT DEFAULT NULL, client_id INT NOT NULL, date_commande DATETIME NOT NULL, prix_total DOUBLE PRECISION DEFAULT NULL, coupon_applique TINYINT(1) DEFAULT NULL, INDEX IDX_6EEAA67D66C5951B (coupon_id), INDEX IDX_6EEAA67D6BF700BD (status_id), INDEX IDX_6EEAA67D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, type_reduction_id INT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, valeur VARCHAR(255) NOT NULL, INDEX IDX_64BF3F02477F0A97 (type_reduction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, reponse LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C53D045FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_id INT NOT NULL, variante_id INT DEFAULT NULL, qte INT NOT NULL, prix_vente DOUBLE PRECISION NOT NULL, INDEX IDX_3170B74BF347EFB (produit_id), INDEX IDX_3170B74B82EA2E54 (commande_id), INDEX IDX_3170B74BD45162B6 (variante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, type_reduction_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, courte_desc VARCHAR(255) NOT NULL, longue_desc VARCHAR(255) NOT NULL, prix_achat DOUBLE PRECISION DEFAULT NULL, prix_vente DOUBLE PRECISION NOT NULL, qte_stock INT NOT NULL, slug VARCHAR(255) NOT NULL, visibilite TINYINT(1) NOT NULL, favoris TINYINT(1) NOT NULL, reduction_applique TINYINT(1) NOT NULL, valeur_reduction DOUBLE PRECISION DEFAULT NULL, INDEX IDX_29A5EC27477F0A97 (type_reduction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_categorie (produit_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_CDEA88D8F347EFB (produit_id), INDEX IDX_CDEA88D8BCF5E72D (categorie_id), PRIMARY KEY(produit_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_reduction (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variante (id INT AUTO_INCREMENT NOT NULL, attribut_id INT NOT NULL, produit_id INT NOT NULL, qte_stock INT DEFAULT NULL, prix_vente DOUBLE PRECISION NOT NULL, INDEX IDX_474CE6B051383AF3 (attribut_id), INDEX IDX_474CE6B0F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribut ADD CONSTRAINT FK_7AB8E85D1704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634727ACA70 FOREIGN KEY (parent_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D66C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F02477F0A97 FOREIGN KEY (type_reduction_id) REFERENCES type_reduction (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BD45162B6 FOREIGN KEY (variante_id) REFERENCES variante (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27477F0A97 FOREIGN KEY (type_reduction_id) REFERENCES type_reduction (id)');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B051383AF3 FOREIGN KEY (attribut_id) REFERENCES attribut (id)');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B0F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE variante DROP FOREIGN KEY FK_474CE6B051383AF3');
        $this->addSql('ALTER TABLE attribut DROP FOREIGN KEY FK_7AB8E85D1704EEB7');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634727ACA70');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8BCF5E72D');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D66C5951B');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF347EFB');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BF347EFB');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8F347EFB');
        $this->addSql('ALTER TABLE variante DROP FOREIGN KEY FK_474CE6B0F347EFB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6BF700BD');
        $this->addSql('ALTER TABLE coupon DROP FOREIGN KEY FK_64BF3F02477F0A97');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27477F0A97');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BD45162B6');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A73F0036');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE attribut');
        $this->addSql('DROP TABLE caracteristique');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_categorie');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type_reduction');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE variante');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
