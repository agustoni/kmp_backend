<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nations-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    	<div class="col-md-4">
	    	<?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

	<div class="row">
    	<div class="col-md-4">
	    	<?= $form->field($model, 'Status')->dropDownList(
	    		['0'=>'Tidak Aktif', "1" => "Aktif"],
	    		['Prompt' => "- Status -"]
	    	) ?>
	    </div>
	</div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
