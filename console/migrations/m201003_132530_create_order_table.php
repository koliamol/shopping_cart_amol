<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m201003_132530_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return false;
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
        $this->dropTable('{{%order}}');
    }

    public function up()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'checkout_details_id' => $this->integer()->notNull(),
            'order_code' => $this->string(16)->unique()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_date' => $this->datetime(),
            'modified_date' => $this->datetime(),
        ]);

        // add foreign key for table `checkout_details`
        $this->addForeignKey(
            'fk-order-checkout_details_id',
            'order',
            'checkout_details_id',
            'checkout_details',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        // drops foreign key for table `checkout_details`
        $this->dropForeignKey('fk-order-checkout_details_id','order');
        $this->dropTable('{{%order}}');
    }
}
