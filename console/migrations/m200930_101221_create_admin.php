<?php

use yii\db\Migration;
use common\models\User;
/**
 * Class m200930_101221_create_admin
 */
class m200930_101221_create_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'admin@123456',
            'status' => 10,
            'verification_token' => null,
        ]);
        if (!$user->insert(false)) {
            $transaction->rollBack();
            return false;
        }
        //$user->confirm();
        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200930_101221_create_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200930_101221_create_admin cannot be reverted.\n";

        return false;
    }
    */
}
