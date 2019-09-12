<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912184831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE aluno (id INT AUTO_INCREMENT NOT NULL, projeto_id INT NOT NULL, nome VARCHAR(255) NOT NULL, matricula VARCHAR(255) NOT NULL, INDEX IDX_67C9710043B58490 (projeto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, matricula VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projeto (id INT AUTO_INCREMENT NOT NULL, professor_id INT NOT NULL, nome VARCHAR(255) NOT NULL, INDEX IDX_A0559D947D2D84D5 (professor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aluno ADD CONSTRAINT FK_67C9710043B58490 FOREIGN KEY (projeto_id) REFERENCES projeto (id)');
        $this->addSql('ALTER TABLE projeto ADD CONSTRAINT FK_A0559D947D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projeto DROP FOREIGN KEY FK_A0559D947D2D84D5');
        $this->addSql('ALTER TABLE aluno DROP FOREIGN KEY FK_67C9710043B58490');
        $this->addSql('DROP TABLE aluno');
        $this->addSql('DROP TABLE professor');
        $this->addSql('DROP TABLE projeto');
    }
}
