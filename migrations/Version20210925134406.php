<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925134406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, type INT NOT NULL, name VARCHAR(255) NOT NULL, phonenumber VARCHAR(20) DEFAULT NULL, taxnumber INT DEFAULT NULL, country VARCHAR(50) NOT NULL, postcode INT NOT NULL, city VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, gross_amount INT NOT NULL, net_amount INT NOT NULL, tax_amount INT NOT NULL, address_type INT NOT NULL, address_name VARCHAR(255) NOT NULL, address_phone VARCHAR(20) DEFAULT NULL, address_tax INT DEFAULT NULL, address_country VARCHAR(50) NOT NULL, address_post_code INT NOT NULL, address_city VARCHAR(50) NOT NULL, address_desc VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql("INSERT INTO address VALUES(1, 0, 'Teszt cím', '0', 1313, 'Magyarország', 6900, 'Makó', 'Luther utca 53.')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE "order"');
    }
}
