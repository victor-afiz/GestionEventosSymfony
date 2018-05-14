<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180514183126 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Participantes');
        $this->addSql('ALTER TABLE usuario CHANGE surname nickname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE eventos ADD descrripcion VARCHAR(600) NOT NULL, ADD date DATETIME NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Participantes (idParticipantes INT NOT NULL, idUsuario INT NOT NULL, idEvento INT NOT NULL, PRIMARY KEY(idParticipantes)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventos DROP descrripcion, DROP date');
        $this->addSql('ALTER TABLE usuario CHANGE nickname surname VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
