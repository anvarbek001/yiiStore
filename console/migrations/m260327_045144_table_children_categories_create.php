<?php

use yii\db\Migration;

class m260327_045144_table_children_categories_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%children_categories}}', [
            'id' => $this->primaryKey(),
            'sub_sub_category_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->null(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-children_categories-sub_sub_category_id',
            '{{%children_categories}}',
            'sub_sub_category_id'
        );

        $this->addForeignKey(
            'fk-children_categories-sub_sub_category_id',
            '{{%children_categories}}',
            'sub_sub_category_id',
            '{{%sub_sub_categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-children_categories-parent_id',
            '{{%children_categories}}',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-children_categories-parent_id',
            '{{%children_categories}}',
            'parent_id',
            '{{%children_categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260327_045144_table_children_categories_create cannot be reverted.\n";

        return false;
    }
    */
}
