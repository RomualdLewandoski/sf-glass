<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715130833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE main_config (id INT AUTO_INCREMENT NOT NULL, header_bg_id INT NOT NULL, gender1_bg_id INT NOT NULL, gender2_bg_id INT NOT NULL, header_title VARCHAR(255) NOT NULL, header_sub VARCHAR(255) NOT NULL, gender1_title VARCHAR(255) NOT NULL, gender1_slug VARCHAR(255) NOT NULL, gender2_title VARCHAR(255) NOT NULL, gender2_slug VARCHAR(255) NOT NULL, INDEX IDX_4B96976A89857B4F (header_bg_id), INDEX IDX_4B96976AC1E529DF (gender1_bg_id), INDEX IDX_4B96976AF00D3342 (gender2_bg_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE main_config ADD CONSTRAINT FK_4B96976A89857B4F FOREIGN KEY (header_bg_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE main_config ADD CONSTRAINT FK_4B96976AC1E529DF FOREIGN KEY (gender1_bg_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE main_config ADD CONSTRAINT FK_4B96976AF00D3342 FOREIGN KEY (gender2_bg_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE main_config');
    }
}
