<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713113526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coupon ADD type_reduction_id INT NOT NULL');
        $this->addSql('ALTER TABLE coupon ADD CONSTRAINT FK_64BF3F02477F0A97 FOREIGN KEY (type_reduction_id) REFERENCES type_reduction (id)');
        $this->addSql('CREATE INDEX IDX_64BF3F02477F0A97 ON coupon (type_reduction_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coupon DROP FOREIGN KEY FK_64BF3F02477F0A97');
        $this->addSql('DROP INDEX IDX_64BF3F02477F0A97 ON coupon');
        $this->addSql('ALTER TABLE coupon DROP type_reduction_id');
    }
}
