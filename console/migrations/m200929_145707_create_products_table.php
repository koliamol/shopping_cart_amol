<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m200929_145707_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return false;
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
        $this->dropTable('{{%products}}');
    }

    public function up()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->unique()->notNull(),
            'price' => $this->float(10,2)->notNull(),
            'description' => $this->text()->notNull(),
            'category' => $this->string(64)->notNull(),
            'image' => $this->string(128)->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_date' => $this->datetime(),
            'modified_date' => $this->datetime(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-products-created_by',
            'products',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-products-updated_by',
            'products',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey('fk-products-updated_by','products');
        $this->dropForeignKey('fk-products-created_by','products');
        $this->dropTable('{{%products}}');
    }
}
