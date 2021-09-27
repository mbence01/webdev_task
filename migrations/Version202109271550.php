<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210927133038 extends AbstractMigration
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
        $this->addSql('CREATE TABLE address (id INT NOT NULL, type INT NOT NULL, name VARCHAR(255) NOT NULL, phonenumber VARCHAR(20) DEFAULT NULL, taxnumber VARCHAR(15) DEFAULT NULL, country VARCHAR(50) NOT NULL, postcode VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, gross_amount INT NOT NULL, net_amount INT NOT NULL, tax_amount INT NOT NULL, address_type INT NOT NULL, address_name VARCHAR(255) NOT NULL, address_phone VARCHAR(20) DEFAULT NULL, address_tax VARCHAR(15) DEFAULT NULL, address_country VARCHAR(50) NOT NULL, address_post_code VARCHAR(10) NOT NULL, address_city VARCHAR(50) NOT NULL, address_desc VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
    
        $this->addSql("INSERT INTO address VALUES(1, 1, 'Teszt Elek', '+36701234567', null, 'Magyarország', 6720, 'Szeged', 'Teszt utca 35.')");
        $this->addSql("INSERT INTO address VALUES(2, 0, 'Remek Elek', '+36307654321', '12345678-3-11', 'Ausztria', 1040, 'Wien', 'Gußhausstraße 29')");
        
        $this->addSql("INSERT INTO \"order\" VALUES(1, 22847, 17990, 4857, 1, 'Teszt Elek', '+36701234567', null, 'Magyarország', 6720, 'Szeged', 'Teszt utca 35.')");
        $this->addSql("INSERT INTO \"order\" VALUES(2, 22847, 17990, 4857, 0, 'Remek Elek', '+36307654321', '12345678-3-11', 'Ausztria', 1040, 'Wien', 'Gußhausstraße 29')");
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
