<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PublishPriceZone;

/**
 * PublishPriceZoneSearch represents the model behind the search form of `app\models\PublishPriceZone`.
 */
class PublishPriceZoneSearch extends PublishPriceZone
{
    /**
     * {@inheritdoc}
     */
    public $category;

    public function rules()
    {
        return [
            [['id', 'id_publish_price_category'], 'integer'],
            [['category'], 'string'],
            [['zone', 'list_id_content', 'category'], 'safe'],
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
        $query = PublishPriceZone::find()->joinWith(['publishPriceCategory ppc']);

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
            'id' => $this->id,
            'id_publish_price_category' => $this->id_publish_price_category,
        ]);

        $query->andFilterWhere(['like', 'zone', $this->zone])
            ->andFilterWhere(['like', 'ppc.name', $this->category]);

        return $dataProvider;
    }
}
