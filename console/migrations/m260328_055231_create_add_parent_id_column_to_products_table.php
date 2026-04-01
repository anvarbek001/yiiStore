<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_parent_id_column_to_products}}`.
 */
class m260328_055231_create_add_parent_id_column_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products', 'parent_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('products', 'parent_id');
    }
}
