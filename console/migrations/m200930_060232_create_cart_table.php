<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m200930_060232_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return false;
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
        $this->dropTable('{{%cart}}');
    }

    public function up()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'session_id' => $this->string(128)->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_date' => $this->datetime(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-cart-user_id',
            'cart',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey('fk-cart-user_id','cart');
        $this->dropTable('{{%cart}}');
    }
}