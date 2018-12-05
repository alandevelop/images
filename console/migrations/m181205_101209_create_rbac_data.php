<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m181205_101209_create_rbac_data
 */
class m181205_101209_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User;
        $user->email = 'admin@admin.com';
        $user->username = 'admin';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->status = 10;
        $user->created_at = $time = time();
        $user->updated_at = $time;
        $user->save();


        $auth = Yii::$app->authManager;

        $assignAdmin = $auth->createPermission('assignAdmin');
        $auth->add($assignAdmin);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $assignAdmin);

        $auth->assign($admin, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181205_101209_create_rbac_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181205_101209_create_rbac_data cannot be reverted.\n";

        return false;
    }
    */
}
