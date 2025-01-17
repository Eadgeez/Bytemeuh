<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250114141237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category_article (category_id INT NOT NULL, article_id INT NOT NULL, PRIMARY KEY(category_id, article_id))');
        $this->addSql('CREATE INDEX IDX_C5E24E1812469DE2 ON category_article (category_id)');
        $this->addSql('CREATE INDEX IDX_C5E24E187294869C ON category_article (article_id)');
        $this->addSql('ALTER TABLE category_article ADD CONSTRAINT FK_C5E24E1812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_article ADD CONSTRAINT FK_C5E24E187294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT fk_23a0e6612469de2');
        $this->addSql('DROP INDEX idx_23a0e6612469de2');
        $this->addSql('ALTER TABLE article ADD image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD short_description TEXT NOT NULL');
        $this->addSql('ALTER TABLE article DROP category_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category_article DROP CONSTRAINT FK_C5E24E1812469DE2');
        $this->addSql('ALTER TABLE category_article DROP CONSTRAINT FK_C5E24E187294869C');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('ALTER TABLE article ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE article DROP image_url');
        $this->addSql('ALTER TABLE article DROP short_description');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT fk_23a0e6612469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_23a0e6612469de2 ON article (category_id)');
    }
}
