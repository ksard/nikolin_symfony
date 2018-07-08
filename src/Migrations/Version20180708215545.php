<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180708215545 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_tasks ADD projects_id INT NOT NULL, DROP name, DROP project_name, CHANGE deadline deadline DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE project_tasks ADD CONSTRAINT FK_430D6C091EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('CREATE INDEX IDX_430D6C091EDE0F55 ON project_tasks (projects_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_tasks DROP FOREIGN KEY FK_430D6C091EDE0F55');
        $this->addSql('DROP INDEX IDX_430D6C091EDE0F55 ON project_tasks');
        $this->addSql('ALTER TABLE project_tasks ADD name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD project_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP projects_id, CHANGE deadline deadline VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
