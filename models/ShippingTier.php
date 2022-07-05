<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shipping_tier".
 *
 * @property int $Id
 * @property string $Tier
 */
class ShippingTier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shipping_tier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Tier'], 'required'],
            [['Tier'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Tier' => 'Tier',
        ];
    }
}
