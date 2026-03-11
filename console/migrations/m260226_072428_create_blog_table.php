<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 */
class m260226_072428_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'discount_price' => $this->integer()->null(),
            'created_at' => $this->date()->notNull(),
            'updated_at' => $this->date()
        ]);
        $this->createIndex('idx-blog-product_id', 'blog', 'product_id');
        $this->addForeignKey(
            'fk-blog-product_id',
            'blog',
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
        $this->dropTable('{{%blog}}');
    }
}
