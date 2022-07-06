<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Id') ?>

    <?= $form->field($model, 'Id_Nations') ?>

    <?= $form->field($model, 'Id_Services') ?>

    <?= $form->field($model, 'Content_Ind') ?>

    <?= $form->field($model, 'Price') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <?php // echo $form->field($model, 'Created') ?>

    <?php // echo $form->field($model, 'Slug') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
