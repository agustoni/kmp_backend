<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contents-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Contents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id' => 'grid-content', 'timeout' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'header' => 'Negara',
                'attribute' => 'Nation',
                'value' => function($model){
                    return $model->nations->Name;
                },

            ],
            [
                'attribute' => 'Id_Services',
                'value' => function($model){
                    return $model->services->Name;
                },
                'filter' => [1=>'export', 2=>'import']
            ],
            'Slug',
            [
                'attribute' => 'Status',
                'value' => function($model){
                    return $model->Status? "<span>Aktif</span>" : "<span class='text-danger'>Tidak Aktif</span>";
                },
                'format' => 'raw',
                'filter' => [0 => 'Tidak Aktif', 1 => 'Aktif']
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'Id' => $model->Id]);
                 }
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager'
        ]
    ]); ?>
    <?php Pjax::end(); ?>

</div>
