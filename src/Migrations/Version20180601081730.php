<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180601081730 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventos CHANGE total_price total_price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pertenece CHANGE mensaje mensaje VARCHAR(655) DEFAULT NULL, CHANGE delet_participante delet_participante INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE delete_user delete_user INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventos CHANGE total_price total_price INT NOT NULL');
        $this->addSql('ALTER TABLE pertenece CHANGE mensaje mensaje VARCHAR(655) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE delet_participante delet_participante INT NOT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE delete_user delete_user INT NOT NULL');
    }
}
