<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_country',
                'value' => function($model){
                    return $model->country->name;
                }
            ],
            [
                'attribute' => 'id_services',
                'value' => function($model){
                    return $model->services->name;
                }
            ],
            [
                'attribute' => 'content',
                'format' => 'raw'
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status? "<span>Aktif</span>" : "<span class='text-danger'>Tidak Aktif</span>";
                },
                'format' => 'raw'
            ],
            // 'created_at',
            // 'created_by',
        ],
    ]) ?>

</div>
