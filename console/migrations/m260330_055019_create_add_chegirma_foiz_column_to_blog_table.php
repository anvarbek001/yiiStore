<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_chegirma_foiz_column_to_blog}}`.
 */
class m260330_055019_create_add_chegirma_foiz_column_to_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('blog', 'chegirma_foiz', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('blog', 'chegirma_foiz');
    }
}
