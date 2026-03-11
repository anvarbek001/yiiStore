<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%korzinka}}`.
 */
class m260226_091818_create_korzinka_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%korzinka}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'count' => $this->integer()->defaultValue(1),
            'price' => $this->integer()->null(),
            'status' => $this->integer()->defaultValue(0),
            'address' => $this->text()->null(),
            'yetkazish_turi' => $this->string()->null(),
            'tolov_turi' => $this->string()->null(),
        ]);

        $this->createIndex('idx-korzinka-user_id', 'korzinka', 'user_id');
        $this->addForeignKey(
            'fk-korzinka-user_id',
            'korzinka',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex('idx-korzinka-product_id', 'korzinka', 'product_id');
        $this->addForeignKey(
            'fk-korzinka-product_id',
            'korzinka',
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
        $this->dropTable('{{%korzinka}}');
    }
}
