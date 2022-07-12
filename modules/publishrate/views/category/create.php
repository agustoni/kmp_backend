<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PublishPriceCategory */

$this->title = 'Create Publish Price Category';
$this->params['breadcrumbs'][] = ['label' => 'Publish Price Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-price-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
