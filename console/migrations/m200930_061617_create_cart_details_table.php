<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_details}}`.
 */
class m200930_061617_create_cart_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return false;
        $this->createTable('{{%cart_details}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
        $this->dropTable('{{%cart_details}}');
    }

    public function up()
    {
        $this->createTable('{{%cart_details}}', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_date' => $this->datetime(),
            'modified_date' => $this->datetime(),
        ]);

        // add foreign key for table `cart_details`
        $this->addForeignKey(
            'fk-cart_details-cart_id',
            'cart_details',
            'cart_id',
            'cart',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        // drops foreign key for table `cart_details`
        $this->dropForeignKey('fk-cart_details-cart_id','cart_details');
        $this->dropTable('{{%cart_details}}');
    }
}
