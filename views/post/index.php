<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Article';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'grid-article', 'timeout' => false]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'value' => function($model){
                    return $model->id;
                },
                'contentOptions' => ['style' => 'width:5%'],
            ],
            [
                'attribute' => 'id_country',
                'value' => function($model){
                    return $model->country->name;
                },
                'contentOptions' => ['style' => 'width:15%'],
            ],
            [
                'attribute' => 'id_services',
                'value' => function($model){
                    return $model->services->name;
                },
                'filter' => [1=>'Export', 2=>'Import'],
                'contentOptions' => ['style' => 'width:15%'],

            ],
            [
                'attribute' => 'content',
                'value' => function($model){
                    // $pos =strpos($content, ' ', 200);
                    // substr($content,0,$pos ); 
                    return substr($model->content, 0, 300)."..."; 
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:40%'],
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status? "<span>Aktif</span>" : "<span class='text-danger'>Tidak Aktif</span>";
                },   
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:15%'],
                'filter' => [1=>'Aktif', 0=>'Tidak'],
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view}  {update}',
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
