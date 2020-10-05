<?php

namespace common\models;

use Yii;
use common\models\behaviors\Masters;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property string $description
 * @property string $category
 * @property string $image
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_date
 * @property string|null $modified_date
 *
 * @property CartDetails[] $cartDetails
 * @property User $createdBy
 * @property User $updatedBy
 */
class Products extends \yii\db\ActiveRecord
{
    use Masters;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'description', 'category', 'image'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['title', 'image'], 'string', 'max' => 128],
            [['category'], 'string', 'max' => 64],
            [['title'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'title' => 'Title',
            'price' => 'Price',
            'description' => 'Description',
            'category' => 'Category',
            'image' => 'Image',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * Gets query for [[CartDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartDetails()
    {
        return $this->hasMany(CartDetails::className(), ['product_id' => 'id']);
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
