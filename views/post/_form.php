<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile(
    'https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);

$this->registerJsFile(
    '@web/web/js/post/form.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);

$this->registerJsFile(
    '@web/web/js/select2/select2.min.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);

$this->registerCssFile(
    '@web/web/css/select2/select2.min.css', 
    ['depends' => [\yii\bootstrap5\BootstrapAsset::className()], 
    'rel' => 'preload stylesheet', 'as' => 'style', 'onload'=>'this.onload=null;this.rel=\'stylesheet\''
]);

$this->registerCssFile(
    '@web/web/css/select2/select2-bootstrap-5-theme.min.css', 
    ['depends' => [\yii\bootstrap5\BootstrapAsset::className()], 
    'rel' => 'preload stylesheet', 'as' => 'style', 'onload'=>'this.onload=null;this.rel=\'stylesheet\''
]);

?>

<div class="post-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="select-country">Negara</label>
            <select data-allow-clear="1" class="form-select" id="select-country" name="Post[id_country]" <?= !empty($model->id_country) ? 'disabled':'' ?> required>
                <option>Please Select</option>
                <?php foreach($dataCountry as $d){ ?>
                    <option value="<?= $d->id ?>" <?= !empty($model->id_country) ? $d->id == $model->id_country ? 'selected':'disabled' : '' ?>><?= $d->name ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="select-services">Jasa</label>
            <select class="form-control" id="select-services" name="Post[id_services]" <?= (!empty($model->id_services) ? 'disabled' : '') ?> required="true">
                <option>Please Select</option>
                <option value="1" <?= (!empty($model->id_services) ? ($model->id_services == 1 ? 'selected=selected' : 'disabled') : '') ?>>Export</option>
                <option value="2" <?= (!empty($model->id_services) ? ($model->id_services == 2 ? 'selected=selected' : 'disabled') : '') ?>>Import</option>
            </select>
        </div>
    </div>

    <div class="row row mb-3">
        <div class="form-group col-md-12">
            <label for="">Content</label>
            <textarea class="form-control" name="Post[content]" rows="5"><?= !empty($model->content) ? $model->content:'' ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    const globalContent = <?= json_encode($model->content) ?>;
</script>
