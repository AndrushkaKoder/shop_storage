<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260207070322 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE
            "order_product"
            (
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                PRIMARY KEY (order_id, product_id)
            )'
        );

        $this->addSql('CREATE INDEX IDX_2530ADE68D9F6D38 ON "order_product" (order_id)');
        $this->addSql('CREATE INDEX IDX_2530ADE64584665A ON "order_product" (product_id)');

        $this->addSql(
            'ALTER TABLE "order_product" ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE'
        );
        $this->addSql(
            'ALTER TABLE "order_product" ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES "product" (id) NOT DEFERRABLE'
        );
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f5299398a76ed395');
        $this->addSql(
            'ALTER TABLE "order" ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "order_product" DROP CONSTRAINT FK_2530ADE68D9F6D38');
        $this->addSql('ALTER TABLE "order_product" DROP CONSTRAINT FK_2530ADE64584665A');
        $this->addSql('DROP TABLE "order_product"');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398A76ED395');
        $this->addSql(
            'ALTER TABLE "order" ADD CONSTRAINT fk_f5299398a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }
}
