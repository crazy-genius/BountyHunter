<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113093512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bounty ADD owner INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bounty ADD CONSTRAINT FK_93BE2C80CF60E67C FOREIGN KEY (owner) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_93BE2C80CF60E67C ON bounty (owner)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bounty DROP FOREIGN KEY FK_93BE2C80CF60E67C');
        $this->addSql('DROP INDEX IDX_93BE2C80CF60E67C ON bounty');
        $this->addSql('ALTER TABLE bounty DROP owner');
    }
}
