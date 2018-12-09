<?php

use yii\db\Migration;

/**
 * Class m181209_065431_alter_feed_table_alter_column_autho_picture_null
 */
class m181209_065431_alter_feed_table_alter_column_autho_picture_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('feed', 'author_picture', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('feed', 'author_picture', $this->string()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181209_065431_alter_feed_table_alter_column_autho_picture_null cannot be reverted.\n";

        return false;
    }
    */
}
