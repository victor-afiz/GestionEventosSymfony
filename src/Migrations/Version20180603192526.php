<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180603192526 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, nickname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, delete_user INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eventos (id INT AUTO_INCREMENT NOT NULL, id_admin INT NOT NULL, nombre_evento VARCHAR(255) NOT NULL, event_image VARCHAR(255) NOT NULL, total_price INT DEFAULT NULL, delete_event INT DEFAULT NULL, descrripcion VARCHAR(600) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pertenece CHANGE mensaje mensaje VARCHAR(655) DEFAULT NULL, CHANGE delet_participante delet_participante INT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE eventos');
        $this->addSql('ALTER TABLE pertenece CHANGE mensaje mensaje VARCHAR(655) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE delet_participante delet_participante INT NOT NULL');
    }
}
