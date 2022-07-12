<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PublishPriceZone */

$this->title = 'Create Zone';
$this->params['breadcrumbs'][] = ['label' => 'Publish Price Zones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-price-zone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
