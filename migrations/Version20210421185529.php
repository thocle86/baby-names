<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421185529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Création totale de la base de données';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about_me (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, my_job_title VARCHAR(255) NOT NULL, my_job_text VARCHAR(1000) NOT NULL, my_news_title VARCHAR(255) NOT NULL, my_news_text VARCHAR(1000) NOT NULL, copyright_year VARCHAR(15) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, text VARCHAR(1000) NOT NULL, link_web VARCHAR(255) DEFAULT NULL, link_git VARCHAR(255) DEFAULT NULL, link_video VARCHAR(255) DEFAULT NULL, link_infos VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_link (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno_project (techno_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_F652711D51F3C1BC (techno_id), INDEX IDX_F652711D166D1F9C (project_id), PRIMARY KEY(techno_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE techno_project ADD CONSTRAINT FK_F652711D51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE techno_project ADD CONSTRAINT FK_F652711D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techno_project DROP FOREIGN KEY FK_F652711D166D1F9C');
        $this->addSql('ALTER TABLE techno_project DROP FOREIGN KEY FK_F652711D51F3C1BC');
        $this->addSql('DROP TABLE about_me');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE social_link');
        $this->addSql('DROP TABLE techno');
        $this->addSql('DROP TABLE techno_project');
        $this->addSql('DROP TABLE user');
    }
}
