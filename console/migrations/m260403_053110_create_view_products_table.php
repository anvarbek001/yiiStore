<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%view_products}}`.
 */
class m260403_053110_create_view_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%view_products}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()
        ]);


        $this->createIndex('idx-view_products-user_id', 'view_products', 'user_id');

        $this->addForeignKey(
            'fk-view_products-user_id',
            'view_products',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-view_products-product_id', 'view_products', 'product_id');
        $this->addForeignKey(
            'fk-view_products-product_id',
            'view_products',
            'product_id',
            'products',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%view_products}}');
    }
}
