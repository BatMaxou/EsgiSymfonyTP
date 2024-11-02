<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241102142755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change Episode duration to INT';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE episode CHANGE duration duration INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE episode CHANGE duration duration TIME NOT NULL');
    }
}
