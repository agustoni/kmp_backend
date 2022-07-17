<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contents".
 *
 * @property int $id
 * @property int $id_country
 * @property int $id_services
 * @property string|null $slug
 * @property string|null $content
 * @property string|null $price
 * @property string|null $price_publish
 * @property int $status
 * @property int $created_by
 * @property string $created_at
 *
 * @property Countries $country
 * @property Admins $createdBy
 * @property Services $services
 */
class Contents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_country', 'id_services', 'status', 'created_by', 'created_at'], 'required'],
            [['id_country', 'id_services', 'status', 'created_by'], 'integer'],
            [['content', 'price', 'price_publish'], 'string'],
            [['created_at'], 'safe'],
            [['slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Admins::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['id_country' => 'Id']],
            [['id_services'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['id_services' => 'Id']],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['savepricepublish'] = ['price_publish']; //Scenario Values Only Accepted
	    return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_country' => 'Id Country',
            'id_services' => 'Service',
            'slug' => 'Slug',
            'content' => 'Content',
            'price' => 'Price',
            'price_publish' => 'Price Publish',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'id_country']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Admins::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Services::className(), ['id' => 'id_services']);
    }
}
