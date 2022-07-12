<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PublishPriceZone */

$this->title = 'Kategori '.$model->publishPriceCategory->name . ' zona '. $model->zone;
$this->params['breadcrumbs'][] = ['label' => 'Publish Price Zones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerCssFile(
    '@web/web/css/datatable/datatables.min.css', 
    ['depends' => [\yii\bootstrap5\BootstrapAsset::className()], 
    'rel' => 'preload stylesheet', 'as' => 'style','onload'=>'this.onload=null;this.rel=\'stylesheet\''
]);
$this->registerJsFile(
    '@web/web/js/datatable/datatables.min.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);
$this->registerJsFile(
    '@web/web/js/modules/setting-publish-rate/zone/view.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);
?>
<div class="publish-price-zone-view">
    <div class="row">
        <div class="col-12">
            <h1 class="text-decoration-underline"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <h3>List Negara</h3>
        </div>
    </div>
    <section id="section-country">
        <div class="row mt-3">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start">Export</h5>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#countryModal" data-bs-type="export" data-bs-idcategory="<?= $model->id_publish_price_category ?>">Tambah Negara</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table" id="datatable-export">
                                    <thead>
                                        <tr>
                                            <th width="90%">Name</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start">Import</h5>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#countryModal" data-bs-type="import" data-bs-idcategory="<?= $model->id_publish_price_category ?>">Tambah Negara</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table" id="datatable-import">
                                    <thead>
                                        <tr>
                                            <th width="90%">Name</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL -->
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryModalLabel">List Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="modal-list-country">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-modal-country" data-type="" data-publishpricezone="<?= $model->id ?>" >Save</button>
            </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
</div>
<script>
    var global_id = <?= $model->id ?>;
</script>