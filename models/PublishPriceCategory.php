<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "publish_price_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property PublishPriceCategoryZone[] $publishPriceCategoryZones
 */
class PublishPriceCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publish_price_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description'
        ];
    }

    /**
     * Gets query for [[PublishPriceZone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublishPriceZones()
    {
        return $this->hasMany(PublishPriceZone::className(), ['id_publish_price_category' => 'id']);
    }
}
