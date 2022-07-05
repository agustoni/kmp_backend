<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nations */

$this->title = 'Update Nations: ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Nations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'Id' => $model->Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
