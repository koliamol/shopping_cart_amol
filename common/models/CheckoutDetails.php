<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "checkout_details".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $session_id
 * @property int $cart_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 * @property string $country
 * @property string $state
 * @property string $city
 * @property int $pincode
 * @property string $address
 * @property int|null $status
 * @property string|null $created_date
 * @property string|null $modified_date
 *
 * @property Cart $cart
 * @property User $user
 */
class CheckoutDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'checkout_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'session_id', 'cart_id', 'pincode', 'status'], 'integer'],
            [['cart_id', 'first_name', 'last_name', 'mobile', 'country', 'state', 'city', 'pincode', 'address'], 'required'],
            [['address'], 'string'],
            [['created_date', 'modified_date'], 'safe'],
            [['mobile'], 'string', 'max' => 12],
            [['first_name', 'last_name', 'country', 'state', 'city'], 'string', 'max' => 32],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'session_id' => 'Session ID',
            'cart_id' => 'Cart ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile' => 'Mobile',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'pincode' => 'Pincode',
            'address' => 'Address',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
