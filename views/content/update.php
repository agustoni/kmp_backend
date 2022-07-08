<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contents */

$this->title = 'Update Contents: ' . $model->country->name;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contents-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => 'update'
    ]) ?>

</div>
