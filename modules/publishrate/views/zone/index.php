<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PublishPriceZoneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publish Price Zones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-price-zone-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Zone', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'category',
                'value' => function($model){
                    return $model->publishPriceCategory->name;
                },
                'format' => 'raw'
            ],
            'zone',
            [
                'label' => 'Description',
                'value' => function($model){
                    $arr_list_content = json_decode($model->list_id_content, TRUE);
                    $arr_type = [];
                    $str = '';
                    if(!empty($arr_list_content)){
                        foreach($arr_list_content as $type => $value){
                            $arr_type[] = $type;
                        }
                        foreach($arr_type as $type){
                            $str .= '<p><b>'. $type .' : </b>'. implode(", ",$arr_list_content[$type]) .'</p>';
                        }

                    }

                    return $str;
                },
                'format' => 'raw'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager'
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
