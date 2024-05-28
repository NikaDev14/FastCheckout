<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230803110217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fields in Shop';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shop ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD zip_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD phone_number VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shop DROP address');
        $this->addSql('ALTER TABLE shop DROP zip_code');
        $this->addSql('ALTER TABLE shop DROP city');
        $this->addSql('ALTER TABLE shop DROP phone_number');
    }
}
