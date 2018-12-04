<?php

use yii\db\Migration;

/**
 * Class m181204_094734_alter_post_table_add_complaints_column
 */
class m181204_094734_alter_post_table_add_complaints_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'complaints', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post', 'complaints');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_094734_alter_post_table_add_complaints_column cannot be reverted.\n";

        return false;
    }
    */
}
