<?php

use yii\db\Migration;

/**
 * Class m181128_083547_alter_user_table
 */
class m181128_083547_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'about', $this->text());
        $this->addColumn('{{%user}}', 'type', $this->integer(3));
        $this->addColumn('{{%user}}', 'picture', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'about');
        $this->dropColumn('{{%user}}', 'type');
        $this->dropColumn('{{%user}}', 'picture');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181128_083547_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
