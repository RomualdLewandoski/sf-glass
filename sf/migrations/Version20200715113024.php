<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715113024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gender_cat ADD header_bg_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gender_cat ADD CONSTRAINT FK_5587C1E389857B4F FOREIGN KEY (header_bg_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_5587C1E389857B4F ON gender_cat (header_bg_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gender_cat DROP FOREIGN KEY FK_5587C1E389857B4F');
        $this->addSql('DROP INDEX IDX_5587C1E389857B4F ON gender_cat');
        $this->addSql('ALTER TABLE gender_cat DROP header_bg_id');
    }
}
