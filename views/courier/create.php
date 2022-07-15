<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Couriers */

$this->title = 'Create Couriers';
$this->params['breadcrumbs'][] = ['label' => 'Couriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="couriers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
