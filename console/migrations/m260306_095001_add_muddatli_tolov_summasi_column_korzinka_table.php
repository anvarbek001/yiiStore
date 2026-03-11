<?php

use yii\db\Migration;

class m260306_095001_add_muddatli_tolov_summasi_column_korzinka_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('korzinka', 'muddatli_tolov_summasi', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('korzinka', 'muddatli_tolov_summasi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260306_095001_add_muddatli_tolov_summasi_column_korzinka_table cannot be reverted.\n";

        return false;
    }
    */
}
