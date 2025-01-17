<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250114091431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE article ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article DROP created_at');
        $this->addSql('ALTER TABLE article DROP updated_at');
    }
}
