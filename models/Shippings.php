<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shippings".
 *
 * @property int $Id
 * @property string $Name
 * @property string|null $Description
 * @property string|null $Alias_Name
 * @property int|null $Surcharge
 * @property int $Status
 */
class Shippings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shippings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Surcharge', 'Status'], 'integer'],
            [['Name', 'Alias_Name'], 'string', 'max' => 50],
            [['Description'], 'string', 'max' => 100],
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
            'Description' => 'Description',
            'Alias_Name' => 'Alias',
            'Surcharge' => 'Surcharge',
            'Status' => 'Status',
        ];
    }
}
