<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $checkout_details_id
 * @property string $order_code
 * @property int|null $status
 * @property string|null $created_date
 * @property string|null $modified_date
 *
 * @property CheckoutDetails $checkoutDetails
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['checkout_details_id', 'order_code'], 'required'],
            [['checkout_details_id', 'status'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['order_code'], 'string', 'max' => 16],
            [['order_code'], 'unique'],
            [['checkout_details_id'], 'exist', 'skipOnError' => true, 'targetClass' => CheckoutDetails::className(), 'targetAttribute' => ['checkout_details_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checkout_details_id' => 'Checkout Details ID',
            'order_code' => 'Order Code',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * Gets query for [[CheckoutDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCheckoutDetails()
    {
        return $this->hasOne(CheckoutDetails::className(), ['id' => 'checkout_details_id']);
    }
}
