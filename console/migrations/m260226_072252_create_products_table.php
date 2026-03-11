<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m260226_072252_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'sub_category_id' => $this->integer()->notNull(),
            'sub_sub_category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'price' => $this->integer()->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->date()->notNull(),
            'updated_at' => $this->date()
        ]);

        $this->createIndex('idx-products-user_id', 'products', 'user_id');

        $this->addForeignKey(
            'fk-products-user_id',
            'products',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-products-category_id', 'products', 'category_id');

        $this->addForeignKey(
            'fk-products-category_id',
            'products',
            'category_id',
            'categories',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-products-sub_category_id', 'products', 'sub_category_id');

        $this->addForeignKey(
            'fk-products-sub_category_id',
            'products',
            'sub_category_id',
            'sub_categories',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-products-sub_sub_category_id', 'products', 'sub_sub_category_id');

        $this->addForeignKey(
            'fk-products-sub_sub_category_id',
            'products',
            'sub_sub_category_id',
            'sub_sub_categories',
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
        $this->dropTable('{{%products}}');
    }
}
