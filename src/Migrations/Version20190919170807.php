<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919170807 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE aluno (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, projeto_id INTEGER DEFAULT NULL, nome VARCHAR(255) NOT NULL, matricula VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_67C9710043B58490 ON aluno (projeto_id)');
        $this->addSql('CREATE TABLE professor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, matricula VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE projeto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, professor_id INTEGER NOT NULL, nome VARCHAR(255) NOT NULL, status_projeto VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_A0559D947D2D84D5 ON projeto (professor_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE aluno');
        $this->addSql('DROP TABLE professor');
        $this->addSql('DROP TABLE projeto');
        $this->addSql('DROP TABLE user');
    }
}
