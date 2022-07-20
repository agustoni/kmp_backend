<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);
$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);

$this->registerJsFile(
   '@web/web/js/modules/setting-publish-rate/price/price-by-category-zone.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);

?>

<div class="publish-price">
    <div class="row mt-4">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5>Publish Price Export</h5>
                </div>
                <form id="form-publish-price-export">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="id-category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="PublishPrice[category]" value="<?= $modelpublispricezone->publishPriceCategory->name ?>" readonly>
                                <input type="hidden" name="PublishPrice[idpublishpricezone]" value="<?= $modelpublispricezone->id ?>">
                                <input type="hidden" name="PublishPrice[type]" value="export">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="upload-file" class="form-label">Upload File</label>
                                <input class="form-control upload-file-xls" type="file" data-type="export" value="" accept=".xlsx, .xls, .csv">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 table-responsive" id="table-publish-price-export">
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success btn-submit-publish-price float-end" data-type="export">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5>Publish Price Import</h5>
                </div>
                <form id="form-publish-price-import">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="id-category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" name="PublishPrice[category]" value="<?= $modelpublispricezone->publishPriceCategory->name ?>" readonly>
                                <input type="hidden" name="PublishPrice[idpublishpricezone]" value="<?= $modelpublispricezone->id ?>">
                                <input type="hidden" name="PublishPrice[type]" value="import">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="upload-file" class="form-label">Upload File</label>
                                <input class="form-control upload-file-xls" type="file" data-type="import" value="" accept=".xlsx, .xls, .csv">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 table-responsive" id="table-publish-price-import">
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success btn-submit-publish-price float-end" data-type="import">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>