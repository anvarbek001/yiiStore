<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop}}`.
 */
class m260226_084222_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull()->defaultValue(1),
            'yetkazish_turi' => $this->string()->defaultValue('Standart'),
            'summa' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->date()->notNull()->defaultValue(date('Y-m-d')),
        ]);

        $this->createIndex('idx-shop-product_id', 'shop', 'product_id');
        $this->addForeignKey(
            'fk-shop-product_id',
            'shop',
            'product_id',
            'products',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex('idx-shop-user_id', 'shop', 'user_id');
        $this->addForeignKey(
            'fk-shop-user_id',
            'shop',
            'user_id',
            'user',
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
        $this->dropTable('{{%shop}}');
    }
}
