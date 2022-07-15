<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PublishPriceCategory */

$this->title = 'Update Publish Price Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Publish Price Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publish-price-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
