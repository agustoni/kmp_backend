<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contents".
 *
 * @property int $Id
 * @property int $Id_Nations
 * @property int $Id_Services
 * @property string|null $Content_Ind
 * @property string|null $Price
 * @property int $Status
 * @property int $CreatedBy
 * @property string $Created
 * @property string|null $Slug
 *
 * @property Admins $createdBy
 * @property Nations $nations
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
            [['Id_Nations', 'Id_Services', 'Status', 'CreatedBy', 'Created'], 'required'],
            [['Id_Nations', 'Id_Services', 'Status', 'CreatedBy'], 'integer'],
            [['Content_Ind', 'Price'], 'string'],
            [['Created'], 'safe'],
            [['Slug'], 'string', 'max' => 100],
            [['Slug'], 'unique'],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => Admins::className(), 'targetAttribute' => ['CreatedBy' => 'id']],
            [['Id_Nations'], 'exist', 'skipOnError' => true, 'targetClass' => Nations::className(), 'targetAttribute' => ['Id_Nations' => 'Id']],
            [['Id_Services'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['Id_Services' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Id_Nations' => 'Id Nations',
            'Id_Services' => 'Id Services',
            'Content_Ind' => 'Content Ind',
            'Price' => 'Price',
            'Status' => 'Status',
            'CreatedBy' => 'Created By',
            'Created' => 'Created',
            'Slug' => 'Slug',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Admins::className(), ['id' => 'CreatedBy']);
    }

    /**
     * Gets query for [[Nations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNations()
    {
        return $this->hasOne(Nations::className(), ['Id' => 'Id_Nations']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Services::className(), ['Id' => 'Id_Services']);
    }
}
