<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714193727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat_product DROP FOREIGN KEY FK_F3FB86FB708A0E0');
        $this->addSql('DROP INDEX IDX_F3FB86FB708A0E0 ON cat_product');
        $this->addSql('ALTER TABLE cat_product DROP gender_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat_product ADD gender_id INT NOT NULL');
        $this->addSql('ALTER TABLE cat_product ADD CONSTRAINT FK_F3FB86FB708A0E0 FOREIGN KEY (gender_id) REFERENCES gender_cat (id)');
        $this->addSql('CREATE INDEX IDX_F3FB86FB708A0E0 ON cat_product (gender_id)');
    }
}
