<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620072410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation between User and Shop';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ADD shop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6494D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D6494D16C4DD ON "user" (shop_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6494D16C4DD');
        $this->addSql('DROP INDEX IDX_8D93D6494D16C4DD');
        $this->addSql('ALTER TABLE "user" DROP shop_id');
    }
}
