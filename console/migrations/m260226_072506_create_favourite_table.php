<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favourite}}`.
 */
class m260226_072506_create_favourite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favourite}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx-favourite-user_id', 'favourite', 'user_id');
        $this->addForeignKey(
            'fk-favourite-user_id',
            'favourite',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex('idx-favourite-product_id', 'favourite', 'product_id');
        $this->addForeignKey(
            'fk-favourite-product_id',
            'favourite',
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
        $this->dropTable('{{%favourite}}');
    }
}
