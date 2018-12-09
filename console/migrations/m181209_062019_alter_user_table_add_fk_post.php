<?php

use yii\db\Migration;

/**
 * Class m181209_062019_alter_user_table_add_fk_post
 */
class m181209_062019_alter_user_table_add_fk_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-post-user_id',
            'post',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-user_id',
            'post',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-post-user_id',
            'post'
        );

        $this->dropIndex(
            'idx-post-user_id',
            'post'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181209_062019_alter_user_table_add_fk_post cannot be reverted.\n";

        return false;
    }
    */
}
