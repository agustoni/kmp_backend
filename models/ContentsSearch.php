<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contents;

/**
 * ContentsSearch represents the model behind the search form of `app\models\Contents`.
 */
class ContentsSearch extends Contents
{
    /**
     * {@inheritdoc}
     */

    public $country;

    public function rules()
    {
        return [
            [['id', 'id_country', 'id_services', 'status', 'created_by'], 'integer'],
            [['country'], 'string'],
            [['slug', 'content', 'price', 'price_publish', 'created_at', 'country'], 'safe'],
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
        $query = Contents::find()->joinWith(['country']);

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
            'contents.id' => $this->id,
            'contents.id_country' => $this->id_country,
            'contents.id_services' => $this->id_services,
            'contents.status' => $this->status,
            'contents.created_by' => $this->created_by,
            'contents.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'countries.name', $this->country])
            ->andFilterWhere(['like', 'price_publish', $this->price_publish]);

        return $dataProvider;
    }
}
