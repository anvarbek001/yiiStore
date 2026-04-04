<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reklama_products}}`.
 */
class m260403_103022_create_reklama_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reklama_products}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()
        ]);

        $this->createIndex('idx-reklama_products-user_id', 'reklama_products', 'user_id');

        $this->addForeignKey(
            'fk-reklama_products-user_id',
            'reklama_products',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-reklama_products-product_id', 'reklama_products', 'product_id');
        $this->addForeignKey(
            'fk-reklama_products-product_id',
            'reklama_products',
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
        $this->dropTable('{{%reklama_products}}');
    }
}
