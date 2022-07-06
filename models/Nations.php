<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nations".
 *
 * @property int $Id
 * @property string $Name
 * @property int|null $Status
 * @property string|null $Ooa_Zipcode
 *
 * @property Contents[] $contents
 */
class Nations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Status'], 'integer'],
            [['Name'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'Status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Contents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Contents::className(), ['Id_Nations' => 'Id']);
    }
}
