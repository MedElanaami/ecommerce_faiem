<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713114855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribut ADD caracteristique_id INT NOT NULL');
        $this->addSql('ALTER TABLE attribut ADD CONSTRAINT FK_7AB8E85D1704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id)');
        $this->addSql('CREATE INDEX IDX_7AB8E85D1704EEB7 ON attribut (caracteristique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribut DROP FOREIGN KEY FK_7AB8E85D1704EEB7');
        $this->addSql('DROP INDEX IDX_7AB8E85D1704EEB7 ON attribut');
        $this->addSql('ALTER TABLE attribut DROP caracteristique_id');
    }
}
