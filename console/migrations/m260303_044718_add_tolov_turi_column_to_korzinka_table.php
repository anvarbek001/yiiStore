<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%korzinka}}`.
 */
class m260303_044718_add_tolov_turi_column_to_korzinka_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('korzinka', 'tolov_turi', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('korzinka', 'tolov_turi');
    }
}
