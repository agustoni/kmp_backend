<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "publish_price_zone".
 *
 * @property int $id
 * @property int|null $id_publish_price_category
 * @property string|null $zone
 * @property string|null $list_id_content
 *
 * @property PublishPriceCategory $publishPriceCategory
 */
class PublishPriceZone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publish_price_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_publish_price_category'], 'integer'],
            [['list_id_content'], 'string'],
            [['zone'], 'string', 'max' => 10],
            [['id_publish_price_category', 'zone'], 'unique', 'targetAttribute' => ['id_publish_price_category', 'zone'], 'message' => 'The combination of Category and Zone has already been taken.'],
            [['id_publish_price_category'], 'exist', 'skipOnError' => true, 'targetClass' => PublishPriceCategory::className(), 'targetAttribute' => ['id_publish_price_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_publish_price_category' => 'Category',
            'zone' => 'Zone',
            'list_id_content' => 'List Id Content',
        ];
    }

    /**
     * Gets query for [[PublishPriceCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublishPriceCategory()
    {
        return $this->hasOne(PublishPriceCategory::className(), ['id' => 'id_publish_price_category']);
    }
}
