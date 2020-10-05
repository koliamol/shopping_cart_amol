<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checkout_details}}`.
 */
class m201003_122314_create_checkout_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return false;
        $this->createTable('{{%checkout_details}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
        $this->dropTable('{{%checkout_details}}');
    }

    public function up()
    {
        $this->createTable('{{%checkout_details}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'session_id' => $this->integer(),
            'cart_id' => $this->integer()->notNull(),
            'first_name' => $this->string(32)->notNull(),
            'last_name' => $this->string(32)->notNull(),
            'mobile' => $this->string(12)->notNull(),
            'country' => $this->string(32)->notNull(),
            'state' => $this->string(32)->notNull(),
            'city' => $this->string(32)->notNull(),
            'pincode' => $this->integer(10)->notNull(),
            'address' => $this->text()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_date' => $this->datetime(),
            'modified_date' => $this->datetime(),
        ]);

        // add foreign key for table `checkout_details`
        $this->addForeignKey(
            'fk-checkout_details-cart_id',
            'checkout_details',
            'cart_id',
            'cart',
            'id',
            'CASCADE'
        );

        // add foreign key for table `checkout_details`
        $this->addForeignKey(
            'fk-checkout_details-user_id',
            'checkout_details',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `checkout_details`
        $this->dropForeignKey('fk-checkout_details-cart_id','checkout_details');
        $this->dropForeignKey('fk-checkout_details-user_id','checkout_details');
        $this->dropTable('{{%checkout_details}}');
    }
}
