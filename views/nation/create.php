<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nations */

$this->title = 'Create Nations';
$this->params['breadcrumbs'][] = ['label' => 'Nations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
