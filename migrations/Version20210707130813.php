<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707130813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_game_category (game_id INT NOT NULL, game_category_id INT NOT NULL, INDEX IDX_7EC7A8CE48FD905 (game_id), INDEX IDX_7EC7A8CCC13DFE0 (game_category_id), PRIMARY KEY(game_id, game_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_device (game_id INT NOT NULL, device_id INT NOT NULL, INDEX IDX_741A1B46E48FD905 (game_id), INDEX IDX_741A1B4694A4C7D4 (device_id), PRIMARY KEY(game_id, device_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_game_category ADD CONSTRAINT FK_7EC7A8CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_category ADD CONSTRAINT FK_7EC7A8CCC13DFE0 FOREIGN KEY (game_category_id) REFERENCES game_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_device ADD CONSTRAINT FK_741A1B46E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_device ADD CONSTRAINT FK_741A1B4694A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD forums_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C618BA34B FOREIGN KEY (forums_id) REFERENCES forum (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C618BA34B ON game (forums_id)');
        $this->addSql('ALTER TABLE message ADD topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F1F55203D ON message (topic_id)');
        $this->addSql('ALTER TABLE post ADD post_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFE0617CD FOREIGN KEY (post_category_id) REFERENCES post_category (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DFE0617CD ON post (post_category_id)');
        $this->addSql('ALTER TABLE topic ADD forum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1B29CCBAD0 ON topic (forum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_game_category');
        $this->addSql('DROP TABLE game_device');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C618BA34B');
        $this->addSql('DROP INDEX UNIQ_232B318C618BA34B ON game');
        $this->addSql('ALTER TABLE game DROP forums_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1F55203D');
        $this->addSql('DROP INDEX IDX_B6BD307F1F55203D ON message');
        $this->addSql('ALTER TABLE message DROP topic_id');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFE0617CD');
        $this->addSql('DROP INDEX IDX_5A8A6C8DFE0617CD ON post');
        $this->addSql('ALTER TABLE post DROP post_category_id');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B29CCBAD0');
        $this->addSql('DROP INDEX IDX_9D40DE1B29CCBAD0 ON topic');
        $this->addSql('ALTER TABLE topic DROP forum_id');
    }
}
