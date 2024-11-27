<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241127152454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add roles to User entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP roles');
    }
}
