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
   '@web/web/js/modules/setting-publish-rate/price/price-by-category-content.js',
    ['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer'],
);

?>
<div class="price-publish-by-content">
    <div class="row">
        <div class="col-12">
            <a href="<?= Yii::$app->urlManager->createUrl(['/content/update', 'id'=>$content->id]) ?>" role="button" class="btn btn-warning">Back to Update Content <?= $content->country->name ?></a>
        </div>
    </div>
    <div class="row mt-4">
        <?php if($content->id_services == 1){ ?>
            <h4>Publish Price Ekspor Indonesia ke <?= $content->country->name ?></h4>
        <?php }else if($content->id_services == 2){ ?>
            <h4>Publish Price Impor <?= $content->country->name ?> ke Indonesia</h4>
        <?php } ?>
    </div>
    <?php foreach($category as $c){ ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><?= $c->name ?></h5>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#countryModal" data-bs-idcategory="<?= $c->id ?>" data-bs-categoryname="<?= strtolower($c->name) ?>" data-bs-idcontent="<?= $content->id ?>">Update To Country With Same Zone</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <?php $key_category = strtolower($c->name); $_key_category = preg_replace('/\s+/', '-', $key_category); if(isset($arr_publish_price[$key_category])){ ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Old Price</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tier</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($arr_publish_price[$key_category] as $tier => $prc){ ?>
                                                    <tr>
                                                        <td><?= $tier ?></td>
                                                        <td><?= $prc ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Old Price</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><i>Price not available</i></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>New Price</h5>
                                    </div>
                                    <form id="form-publish-price-<?= $_key_category ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="id-category" class="form-label">Kategori</label>
                                                    <input type="text" class="form-control" name="PublishPrice[category]" value="<?= $key_category ?>" readonly>
                                                    <input type="hidden" name="PublishPrice[idcontent]" value="<?= $content->id ?>">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <label for="upload-file" class="form-label">Upload File</label>
                                                    <input class="form-control upload-file-xls" type="file" value="" data-type="<?= $_key_category ?>" accept=".xlsx, .xls, .csv">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 table-responsive" id="table-publish-price-<?= $_key_category ?>">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-success btn-submit-publish-price float-end" data-type="<?= $_key_category ?>">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
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
                <button type="button" class="btn btn-primary" id="save-modal-country" data-category="" data-idcontent="<?= $content->id ?>">submit</button>
            </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
<script>
    const global_list_content = JSON.parse('<?= json_encode($arr_country_zone) ?>');
</script>