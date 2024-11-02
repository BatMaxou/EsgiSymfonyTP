<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241030201644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Missing fields in Playlist and PlaylistSubscription entities';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE playlist CHANGE created_at created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE updated_at updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE playlist_subscription ADD subscribed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE playlist_subscription DROP subscribed_at');
        $this->addSql('ALTER TABLE playlist CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
