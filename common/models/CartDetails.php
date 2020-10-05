<?php

namespace common\models;

use Yii;
use common\models\behaviors\Masters;
use common\models\User;
/**
 * This is the model class for table "cart_details".
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int $quantity
 * @property int|null $status
 * @property string|null $created_date
 *
 * @property Cart $cart
 */
class CartDetails extends \yii\db\ActiveRecord
{
    //use Masters;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'quantity'], 'required'],
            [['cart_id', 'product_id', 'quantity', 'status'], 'integer'],
            [['created_date'], 'safe'],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * Gets query for [[Cart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserName()
    {
        $user = User::find()->select(['username'])->where(['id'=>$this->cart->user_id])->one();
        return $user->username;
    }
}
