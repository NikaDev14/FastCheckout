<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905101059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT fk_ba388b7a76ed395');
        $this->addSql('DROP INDEX idx_ba388b7a76ed395');
        $this->addSql('ALTER TABLE cart RENAME COLUMN user_id TO customer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cart RENAME COLUMN customer_id TO user_id');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT fk_ba388b7a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ba388b7a76ed395 ON cart (user_id)');
    }
}
