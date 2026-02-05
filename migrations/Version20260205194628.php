<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260205194628 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            '
            CREATE TABLE category_product
            (
                category_id INT NOT NULL,
                product_id INT NOT NULL,
                PRIMARY KEY (category_id, product_id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_149244D312469DE2 ON category_product (category_id)');
        $this->addSql('CREATE INDEX IDX_149244D34584665A ON category_product (product_id)');

        $this->addSql(
            'ALTER TABLE category_product ADD CONSTRAINT FK_149244D312469DE2 FOREIGN KEY (category_id) REFERENCES "category" (id) ON DELETE CASCADE NOT DEFERRABLE'
        );
        $this->addSql(
            'ALTER TABLE category_product ADD CONSTRAINT FK_149244D34584665A FOREIGN KEY (product_id) REFERENCES "product" (id) ON DELETE CASCADE NOT DEFERRABLE'
        );
        $this->addSql(
            'ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES "category" (id) ON DELETE SET NULL NOT DEFERRABLE'
        );
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('ALTER TABLE product ADD is_active BOOLEAN NOT NULL');
        $this->addSql('CREATE INDEX products_active_idx ON product (is_active)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category_product DROP CONSTRAINT FK_149244D312469DE2');
        $this->addSql('ALTER TABLE category_product DROP CONSTRAINT FK_149244D34584665A');
        $this->addSql('DROP TABLE category_product');
        $this->addSql('ALTER TABLE "category" DROP CONSTRAINT FK_64C19C1727ACA70');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70');
        $this->addSql('DROP INDEX products_active_idx');
        $this->addSql('ALTER TABLE "product" DROP is_active');
    }
}
