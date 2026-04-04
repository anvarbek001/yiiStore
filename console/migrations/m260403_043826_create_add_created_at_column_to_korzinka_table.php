<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_created_at_column_to_korzinka}}`.
 */
class m260403_043826_create_add_created_at_column_to_korzinka_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('korzinka', 'created_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('korzinka', 'created_at');
    }
}
