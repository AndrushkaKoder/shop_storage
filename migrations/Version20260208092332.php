<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260208092332 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT fk_2530ade68d9f6d38');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT fk_2530ade64584665a');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES "product" (id) ON DELETE CASCADE NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "order_product" DROP CONSTRAINT FK_2530ADE68D9F6D38');
        $this->addSql('ALTER TABLE "order_product" DROP CONSTRAINT FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE "order_product" ADD CONSTRAINT fk_2530ade68d9f6d38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order_product" ADD CONSTRAINT fk_2530ade64584665a FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
