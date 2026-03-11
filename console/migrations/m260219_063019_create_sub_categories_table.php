<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sub_categories}}`.
 */
class m260219_063019_create_sub_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sub_categories}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()
        ]);

        $this->createIndex('idx-sub_categories-category_id', 'sub_categories', 'category_id');

        $this->addForeignKey(
            'fk-sub_categories-category_id',
            'sub_categories',
            'category_id',
            'categories',
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
        $this->dropTable('{{%sub_categories}}');
    }
}
