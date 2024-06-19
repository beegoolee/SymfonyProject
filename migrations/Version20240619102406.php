<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619102406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wall_post (id INT AUTO_INCREMENT NOT NULL, related_wall_owner_id INT NOT NULL, post_author_id INT NOT NULL, text VARCHAR(1024) DEFAULT NULL, timestamp VARCHAR(64) NOT NULL, INDEX IDX_9C2718ACB4B60690 (related_wall_owner_id), INDEX IDX_9C2718AC571B8DEC (post_author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wall_post ADD CONSTRAINT FK_9C2718ACB4B60690 FOREIGN KEY (related_wall_owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wall_post ADD CONSTRAINT FK_9C2718AC571B8DEC FOREIGN KEY (post_author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA4A1EB6C9 FOREIGN KEY (chat_owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_659DF2AA4A1EB6C9 ON chat (chat_owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wall_post DROP FOREIGN KEY FK_9C2718ACB4B60690');
        $this->addSql('ALTER TABLE wall_post DROP FOREIGN KEY FK_9C2718AC571B8DEC');
        $this->addSql('DROP TABLE wall_post');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA4A1EB6C9');
        $this->addSql('DROP INDEX IDX_659DF2AA4A1EB6C9 ON chat');
    }
}
