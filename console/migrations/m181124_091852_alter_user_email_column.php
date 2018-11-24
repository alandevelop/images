<?php

use yii\db\Migration;

/**
 * Class m181124_091852_alter_user_email_column
 */
class m181124_091852_alter_user_email_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user', 'email', $this->string()->notNull()->unique());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181124_091852_alter_user_email_column cannot be reverted.\n";

        return false;
    }
    */
}
