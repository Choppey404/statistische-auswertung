<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206205622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'relation legalservice to appointment';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD legal_service_id INT NOT NULL, CHANGE from_date from_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE to_date to_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844F1DC01BB FOREIGN KEY (legal_service_id) REFERENCES legal_service (id)');
        $this->addSql('CREATE INDEX IDX_FE38F844F1DC01BB ON appointment (legal_service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down(N) migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844F1DC01BB');
        $this->addSql('DROP INDEX IDX_FE38F844F1DC01BB ON appointment');
        $this->addSql('ALTER TABLE appointment DROP legal_service_id, CHANGE from_date from_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE to_date to_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
