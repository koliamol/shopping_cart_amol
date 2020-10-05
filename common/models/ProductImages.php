<?php

namespace common\models;

use Yii;
use common\models\behaviors\Masters;

/**
 * This is the model class for table "product_images".
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_name
 * @property int|null $status
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $created_date
 * @property string|null $modified_date
 *
 * @property User $createdBy
 * @property Products $product
 * @property User $updatedBy
 */
class ProductImages extends \yii\db\ActiveRecord
{
    use Masters;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image_name', 'status'], 'required'],
            [['product_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['image_name'], 'string', 'max' => 128],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image_name' => 'Image Name',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
