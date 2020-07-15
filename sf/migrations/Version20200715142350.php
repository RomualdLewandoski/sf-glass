<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715142350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_config ADD how_works_bg_id INT NOT NULL, ADD learn_more LONGTEXT NOT NULL, ADD care_and_tips LONGTEXT NOT NULL, ADD how_works LONGTEXT NOT NULL, ADD seen_on_press LONGTEXT NOT NULL, ADD maps_url VARCHAR(255) NOT NULL, ADD about_us LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE site_config ADD CONSTRAINT FK_A4248123513FC6EF FOREIGN KEY (how_works_bg_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_A4248123513FC6EF ON site_config (how_works_bg_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_config DROP FOREIGN KEY FK_A4248123513FC6EF');
        $this->addSql('DROP INDEX IDX_A4248123513FC6EF ON site_config');
        $this->addSql('ALTER TABLE site_config DROP how_works_bg_id, DROP learn_more, DROP care_and_tips, DROP how_works, DROP seen_on_press, DROP maps_url, DROP about_us');
    }
}
