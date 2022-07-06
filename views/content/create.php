<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contents */

$this->title = 'Create Contents';
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => 'create'
    ]) ?>

</div>
