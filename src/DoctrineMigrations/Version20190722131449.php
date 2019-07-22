<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190722131449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE prestation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE invoice (id UUID NOT NULL, invoice_status_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, emited_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_90651744E58F121 ON invoice (invoice_status_id)');
        $this->addSql('CREATE TABLE company (id UUID NOT NULL, owner_id UUID DEFAULT NULL, company_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, post_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F7E3C61F9 ON company (owner_id)');
        $this->addSql('CREATE TABLE profile (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE client (id UUID NOT NULL, profile_id UUID DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, post_code VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7440455CCFA12B8 ON client (profile_id)');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, status_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE massage (id UUID NOT NULL, type VARCHAR(255) NOT NULL, ht_price NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE prestation (id BIGINT NOT NULL, client_id UUID DEFAULT NULL, massage_id UUID DEFAULT NULL, invoice_id UUID DEFAULT NULL, prestation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51C88FAD19EB6921 ON prestation (client_id)');
        $this->addSql('CREATE INDEX IDX_51C88FADE964225 ON prestation (massage_id)');
        $this->addSql('CREATE INDEX IDX_51C88FAD2989F1FD ON prestation (invoice_id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744E58F121 FOREIGN KEY (invoice_status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FADE964225 FOREIGN KEY (massage_id) REFERENCES massage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE prestation DROP CONSTRAINT FK_51C88FAD2989F1FD');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455CCFA12B8');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094F7E3C61F9');
        $this->addSql('ALTER TABLE prestation DROP CONSTRAINT FK_51C88FAD19EB6921');
        $this->addSql('ALTER TABLE invoice DROP CONSTRAINT FK_90651744E58F121');
        $this->addSql('ALTER TABLE prestation DROP CONSTRAINT FK_51C88FADE964225');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE prestation_id_seq CASCADE');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE massage');
        $this->addSql('DROP TABLE prestation');
    }
}
