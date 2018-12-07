<?php

use yii\db\Migration;

/**
 * Class m181206_072756_alter_feed_table_add_foreign_key_for_post
 */
class m181206_072756_alter_feed_table_add_foreign_key_for_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-feed-post_id',
            'feed',
            'post_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-feed-post_id',
            'feed',
            'post_id',
            'post',
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
            'fk-feed-post_id',
            'feed'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-feed-post_id',
            'feed'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181206_072756_alter_feed_table_add_foreign_key_for_post cannot be reverted.\n";

        return false;
    }
    */
}
