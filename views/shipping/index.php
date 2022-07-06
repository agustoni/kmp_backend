<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shippings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shippings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Shippings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'grid-shipping', 'timeout' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Name',
            [
                'attribute' => 'Description',
                'value' => function($model){
                    return ($model->Description) ? $model->Description : "-";
                }
            ],
            [
                'attribute' => 'Alias_Name',
                'value' => function($model){
                    return ($model->Alias_Name) ? $model->Alias_Name : "-";
                }
            ],
            'Surcharge',
            [
                'attribute' => 'Status',
                'value' => function($model){
                    return $model->Status ? "<span>Aktif</span>" : "<span class='text-danger'>Tidak Aktif</span>";
                },
                'format' => 'raw',
                'filter' => ['0' => 'Tidak', '1'=> 'Aktif']
            ],
            [
                'class' => ActionColumn::className(),
                'template'=>'{view} {update}',
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
