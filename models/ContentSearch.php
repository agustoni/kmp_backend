<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contents;

class ContentSearch extends Contents{
    public $Nation;
   
    public function rules()
    {
        return [
            [['Id', 'Id_Services', 'Status', 'CreatedBy'], 'integer'],
            [['Content_Ind', 'Price', 'Created', 'Slug', 'Id_Nations', 'Nation'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Contents::find()->joinWith(['nations n'])->orderBy('n.Name');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Id' => $this->Id,
            // 'Id_Nations' => $this->Id_Nations,
            'Id_Services' => $this->Id_Services,
            'contents.Status' => $this->Status,
            'CreatedBy' => $this->CreatedBy,
            'Created' => $this->Created,
        ]);

        // if($this->Nation != ''){
            echo "<h1>".$this->Nation."</h1>";
        // }

        $query->andFilterWhere(['like', 'Content_Ind', $this->Content_Ind])
            ->andFilterWhere(['like', 'Price', $this->Price])
            ->andFilterWhere(['like', 'n.Name', $this->Nation])
            ->andFilterWhere(['like', 'Slug', $this->Slug]);

        return $dataProvider;
    }
}
