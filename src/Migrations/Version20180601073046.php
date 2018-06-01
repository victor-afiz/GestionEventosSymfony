<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180601073046 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pertenece (id INT AUTO_INCREMENT NOT NULL, id_usuario INT NOT NULL, id_evento INT NOT NULL, mensaje VARCHAR(655) NOT NULL, delet_participante INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventos ADD event_image VARCHAR(255) NOT NULL, ADD total_price INT NOT NULL, ADD delete_event INT NOT NULL, ADD descrripcion VARCHAR(600) NOT NULL, ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE usuario ADD delete_user INT NOT NULL, CHANGE surname nickname VARCHAR(100) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pertenece');
        $this->addSql('ALTER TABLE eventos DROP event_image, DROP total_price, DROP delete_event, DROP descrripcion, DROP date');
        $this->addSql('ALTER TABLE usuario DROP delete_user, CHANGE nickname surname VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
