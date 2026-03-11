<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sub_sub_categories}}`.
 */
class m260226_071917_create_sub_sub_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sub_sub_categories}}', [
            'id'              => $this->primaryKey(),
            'category_id'     => $this->integer()->notNull(),
            'sub_category_id' => $this->integer()->notNull(),
            'name'            => $this->string()->notNull(),
            'created_at'      => $this->integer(),
            'updated_at'      => $this->integer(),
        ]);

        $this->createIndex(
            'idx-sub_sub_categories-category_id',
            '{{%sub_sub_categories}}',
            'category_id'
        );

        $this->createIndex(
            'idx-sub_sub_categories-sub_category_id',
            '{{%sub_sub_categories}}',
            'sub_category_id'
        );

        // category_id → categories jadvaliga
        $this->addForeignKey(
            'fk-sub_sub_categories-category_id',
            '{{%sub_sub_categories}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // sub_category_id → sub_categories jadvaliga
        $this->addForeignKey(
            'fk-sub_sub_categories-sub_category_id',
            '{{%sub_sub_categories}}',
            'sub_category_id',
            '{{%sub_categories}}',
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
        $this->dropTable('{{%sub_sub_categories}}');
    }
}
