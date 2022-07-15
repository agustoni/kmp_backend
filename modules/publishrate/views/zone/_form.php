<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PublishPriceZone */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="publish-price-zone-form">
    <div class="row">
        <div class="col-6">
            <?php $form = ActiveForm::begin(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'id_publish_price_category')->dropDownList(
                                                        ArrayHelper::map($category,'id',
                                                            function($c){
                                                                return $c['name'];
                                                            }
                                                        ),
                                                        ['prompt'=>'Category']
                                                    ); ?>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div cl`ass="form-group">
                        <?= Html::submitButton('Save', ['id'=>'button-submit', 'class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>