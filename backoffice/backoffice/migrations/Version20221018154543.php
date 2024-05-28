<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018154543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_articles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, shop_id INT NOT NULL, reference_article VARCHAR(255) NOT NULL, libelle_article VARCHAR(255) NOT NULL, price_article DOUBLE PRECISION NOT NULL, quantity_article INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E6654AABCE ON article (reference_article)');
        $this->addSql('CREATE INDEX IDX_23A0E664D16C4DD ON article (shop_id)');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, shop_id INT DEFAULT NULL, user_id INT DEFAULT NULL, total_amount DOUBLE PRECISION DEFAULT NULL, is_active BOOLEAN NOT NULL, is_validate BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BA388B74D16C4DD ON cart (shop_id)');
        $this->addSql('CREATE INDEX IDX_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('CREATE TABLE cart_articles (id INT NOT NULL, cart_id INT NOT NULL, article_id INT NOT NULL, nb_items INT NOT NULL, previous_nb_items INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_21427E031AD5CDBF ON cart_articles (cart_id)');
        $this->addSql('CREATE INDEX IDX_21427E037294869C ON cart_articles (article_id)');
        $this->addSql('CREATE TABLE shop (id INT NOT NULL, name_shop VARCHAR(255) NOT NULL, reference_shop VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC6A4CA2EBDC96D5 ON shop (name_shop)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC6A4CA2DBA9B402 ON shop (reference_shop)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B74D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_articles ADD CONSTRAINT FK_21427E031AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_articles ADD CONSTRAINT FK_21427E037294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cart_articles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E664D16C4DD');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B74D16C4DD');
        $this->addSql('ALTER TABLE cart DROP CONSTRAINT FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_articles DROP CONSTRAINT FK_21427E031AD5CDBF');
        $this->addSql('ALTER TABLE cart_articles DROP CONSTRAINT FK_21427E037294869C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_articles');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE "user"');
    }
}
