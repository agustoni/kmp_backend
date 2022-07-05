<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shippings */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="shippings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Id' => $model->Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Id' => $model->Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Id',
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
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
