<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20151223144742 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article_tag (tag_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_919694F9BAD26311 (tag_id), INDEX IDX_919694F97294869C (article_id), PRIMARY KEY(tag_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');

        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE password_resets');
        $this->addSql('DROP TABLE users');

        $this->addSql(
            'INSERT INTO article_tag (tag_id, article_id)
  SELECT t.id, a.id
  FROM lh_laratest.article as a
  INNER JOIN lh_laratest.tag as t ON t.article_id = a.id'
        );

        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7837294869C');
        $this->addSql('DROP INDEX IDX_389B7837294869C ON tag');
        $this->addSql('ALTER TABLE tag DROP article_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contacts (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, body TEXT NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, excerpt TEXT NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE password_resets (email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, token VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, INDEX password_resets_email_index (email), INDEX password_resets_token_index (token)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci, remember_token VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, UNIQUE INDEX users_email_unique (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('ALTER TABLE tag ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7837294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_389B7837294869C ON tag (article_id)');
    }
}
