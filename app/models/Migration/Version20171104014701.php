<?php

namespace Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171104014701 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE station_media ADD unique_id VARCHAR(25) DEFAULT NULL');
    }

    public function postUp(Schema $schema)
    {
        $all_records = $this->connection->fetchAll("SELECT * FROM station_media");

        foreach ($all_records as $record) {
            $this->connection->update('station_media', [
                'unique_id' => bin2hex(random_bytes(12)),
            ], [
                'id' => $record['id'],
            ]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE station_media DROP unique_id');
    }
}
