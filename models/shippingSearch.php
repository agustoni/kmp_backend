<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shippings;

/**
 * ShippingSearch represents the model behind the search form of `app\models\Shippings`.
 */
class ShippingSearch extends Shippings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Surcharge', 'Status'], 'integer'],
            [['Name', 'Description', 'Alias_Name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Shippings::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Id' => $this->Id,
            'Surcharge' => $this->Surcharge,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Alias_Name', $this->Alias_Name]);

        return $dataProvider;
    }
}
