<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contents-form">

    <?php $form = ActiveForm::begin(['id' => 'form-contens']); ?>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-general-tab" data-bs-toggle="tab" data-bs-target="#nav-general" type="button" role="tab" aria-controls="nav-general" aria-selected="true">
                General
            </button>
            <button class="nav-link" id="nav-meta-tab" data-bs-toggle="tab" data-bs-target="#nav-meta" type="button" role="tab" aria-controls="nav-meta" aria-selected="false">
                Meta
            </button>
            <button class="nav-link" id="nav-pricetax-tab" data-bs-toggle="tab" data-bs-target="#nav-pricetax" type="button" role="tab" aria-controls="nav-pricetax" aria-selected="false">
                Price dan Tax
            </button>
            <button class="nav-link" id="nav-documeninfo-tab" data-bs-toggle="tab" data-bs-target="#nav-documeninfo" type="button" role="tab" aria-controls="nav-documeninfo" aria-selected="false">
                Dokumen dan Informasi
            </button>
        </div>
    </nav>
    <div class="tab-content border p-2 mb-3" id="nav-tabContent">
        <!-- GENERAL TAB -->
        <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
            <div class="row mb-2">
                <div class="form-group col-md-4">
                    <label for="inputNations">Negara</label>
                    <input type="text" class="form-control typeahead" id="inputNations" autocomplete="off" placeholder="Ketikan nama negara..." value="<?= !empty($model->Id_Nations) ? $model->nations->Name : '' ?>" required="true" <?= $type == 'update' ? 'readonly':'' ?>>
                    <input type="hidden" name="Content[inputnations]" id="inputNationshidden" value="<?= !empty($model->Id_Nations) ? $model->Id_Nations : '' ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="label-Id_Services">Jasa</label>
                    <select class="form-select" id="inputServices" name="Content[inputservices]" required="true">
                        <option <?= (!empty($model->Id_Services) ? 'disabled' : '') ?>>Please Select</option>
                        <option value="1" <?= (!empty($model->Id_Services) ? ($model->Id_Services == 1 ? 'selected=selected' : 'disabled') : '') ?>>Export</option>
                        <option value="2" <?= (!empty($model->Id_Services) ? ($model->Id_Services == 2 ? 'selected=selected' : 'disabled') : '') ?>>Import</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="basic-url">URL</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon-url"><?= ($model->Id_Services == 1 ? 'jasa-kirim-ekspor/' : ($model->Id_Services == 2 ? 'jasa-kirim-impor/' : '')) ?></span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" required="true" name="Content[slug]" value="<?= !empty($model->Slug) ? $model->Slug : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label >Banner Desktop <br> <span class="text-danger">*dimensi gambar (1347px x 300px)</span></label>
                    <div id="inputBackgroundImagesDesktop">
                        <input type="file" class="btn btn-info" id="fileuploaddesktopbackground">
                        <input type="hidden" name="Content[imageDesktopBackground]" id="hiddenInputImageBackgroundDesktop">
                    </div>
                    <div id="backgroundImagesDesktop">
                    </div>
                    <img src="" class="img-fluid"  id="imgBackgroundDesktop">
                </div>
                <div class="col-6">
                    <label for="basic-url">Banner Mobile <br> <span class="text-danger">*dimensi gambar (350px x 230px)</span></label>
                    <div id="inputBackgroundImagesMobile">
                        <input type="file" class="btn btn-info" id="fileuploadmobilebackground">
                        <input type="hidden" name="Content[imageMobileBackground]" id="hiddenInputImageBackgroundMobile">
                    </div>
                    <div id="backgroundImagesMobile">
                    </div>
                    <img src="" class="img-fluid" style="" id="imgBackgroundMobile">
                </div>
            </div>
        </div>
        <!-- END GENERAL TAB -->

        <!-- META TAB -->
        <div class="tab-pane fade" id="nav-meta" role="tabpanel" aria-labelledby="nav-meta-tab">
            <div class="row mb-3">
                <div class="form-group col-md-4">
                    <label for="metaTitle">Title</label>
                    <textarea class="form-control" id="metaTitle" rows="5" name="Content[meta][title]"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="metaKeyword">Keyword</label>
                    <textarea class="form-control" id="metaKeyword" rows="5" name="Content[meta][keyword]"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="metaDescription">Description</label>
                    <textarea class="form-control" id="metaDescription" rows="5" name="Content[meta][description]"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="metaH1">H1</label>
                    <input type="text" class="form-control" id="metaH1" name="Content[meta][h1]">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="metaH2">H2</label>
                    <input type="text" class="form-control" id="metaH2" name="Content[meta][h2]">
                </div>
            </div>
        </div>
        <!-- END META TAB -->

        <!-- PRICE TAX TAB -->
        <div class="tab-pane fade" id="nav-pricetax" role="tabpanel" aria-labelledby="nav-pricetax-tab">
            <div class="row mb-3">
                <div class="col-md-12">
                    <p class="text-danger">*Harga dapat di isi ketika content sudah dibuat</p>
                    <a href="<?= yii::$app->urlManager->createUrl(['price/index', 'idcontent' => $model->Id]); ?>"><button type="button" class="btn btn-outline-primary" <?= $type=='create' ? 'disabled' :'' ?>>Klik Disini Untuk Update Estimasi Harga</button></a>
                    <?php 
                        if(!empty($model->Price)){
                            $prc = json_decode($model->Price, true);
                            $shipping = array_keys($prc);
                            $tier = array_keys($prc[$shipping[0]]['sellingprice']);
                        ?>
                        <table class="table table-bordered text-center mt-4">
                            <thead>
                                <tr class="table-primary">
                                    <th>Tier</th>
                                    <?php foreach($shipping as $s){ ?>
                                        <th><?= $s ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i=0; $i<count($tier); $i++){ ?>
                                <tr>
                                    <td><?= $tier[$i] ?></td>
                                    <?php foreach($shipping as $s) { ?>
                                        <td><?= $prc[$s]['sellingprice'][$tier[$i]] ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td>Estimasi</td>
                                    <?php foreach($shipping as $s) { ?>
                                        <td><?= $prc[$s]['estimasihari'] ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="inputTaxAmount">Tax</label>
                     <input type="number" class="form-control" id="inputTaxAmount" name="Content[tax][amount]">
                </div>
                <div class="form-group col-md-6">
                    <label for="selectTaxCurrency">Currency</label>
                    <select class="form-control" id="selectTaxCurrency" name="Content[tax][currency]">
                        <option value="usd">&#36;</option>
                        <option value="euro">&#8364;</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="inputTaxDescription">Description</label>
                    <input type="text" class="form-control" id="inputTaxDescription" name="Content[tax][description]">
                </div>
            </div>
        </div>
        <!-- END PRICE TAX TAB -->

        <!-- DOKUMEN INFORMASI -->
        <div class="tab-pane fade" id="nav-documeninfo" role="tabpanel" aria-labelledby="nav-documeninfo-tab">
            <div class="row">
                <div class="col-md-12">
                    <label for="inputRestrictionContent">List Barang yang tidak diperbolehkan</label>
                    <textarea class="form-control" id="inputRestrictionContent" name="Content[restriction][content]" rows="5"></textarea>
                </div>
            </div>
        </div>
        <!-- END DOKUMEN INFORMASI -->
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script>
    var globalContent = <?= json_encode($model->Content_Ind) ?>;

    $(document).ready(function() {
        $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
            $("#inputNationshidden").val(suggestion.id)
        });

        if (globalContent != null) {
            var obj = JSON.parse(globalContent);
            
            $("#metaTitle").val(obj['meta']['title'])
            $("#metaKeyword").val(obj['meta']['keyword'])
            $("#metaDescription").val(obj['meta']['description'])
            $("#metaH1").val(obj['meta']['h1'])
            $("#metaH2").val(obj['meta']['h2'])

            if (obj['tax']) {
                if (obj['tax']['amount']) {
                    $("#inputTaxAmount").val(obj['tax']['amount'])
                }
                if (obj['tax']['currency']) {
                    $("#selectTaxCurrency").val(obj['tax']['currency'])
                }
                if (obj['tax']['description']) {
                    $("#inputTaxDescription").val(obj['tax']['description'])
                }
            }
            
            if (obj['restriction']) {
                if (obj['restriction']['content']) {
                    $("#inputRestrictionContent").val(obj['restriction']['content'])
                }
            }

            if (obj['desktopBanner']) {
                $("<h3>" + obj['desktopBanner'] + "</h3>").appendTo("#backgroundImagesDesktop");
                $("#hiddenInputImageBackgroundDesktop").val(obj['desktopBanner']);
                var btn = $(`
                            <button type="button" class="btn btn-danger" id="deleteImageBackgroundDesktop" data-id="` + obj['desktopBanner'] + `">delete</button>
                    `)
                $("#inputBackgroundImagesDesktop").append(btn);
                var base_url = window.location.origin;
                if (base_url == "http://localhost") {
                    $("#imgBackgroundDesktop").attr("src", base_url + "/kmp/frontend/web/images/banner/" + obj['desktopBanner']);
                } else {
                    $("#imgBackgroundDesktop").attr("src", base_url + "/frontend/web/images/banner/" + obj['desktopBanner']);
                }
            }

            if (obj['mobileBanner']) {
                $("<h3>" + obj['mobileBanner'] + "</h3>").appendTo("#backgroundImagesMobile");
                $("#hiddenInputImageBackgroundMobile").val(obj['mobileBanner']);
                var btn = $(`
                            <button type="button" class="btn btn-danger" id="deleteImageBackgroundMobile" data-id="` + obj['mobileBanner'] + `">delete</button>
                    `)
                $("#inputBackgroundImagesMobile").append(btn);
                var base_url = window.location.origin;
                if (base_url == "http://localhost") {
                    $("#imgBackgroundMobile").attr("src", base_url + "/kmp/frontend/web/images/banner/" + obj['mobileBanner']);
                } else {
                    $("#imgBackgroundMobile").attr("src", base_url + "/frontend/web/images/banner/" + obj['mobileBanner']);
                }
            }
        }
    })

/* SCRIPT TAB GENERAL */
    var nations = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '<?php echo Yii::$app->urlManager->createUrl('content/get-nations'); ?>?q=%QUERY',
            wildcard: '%QUERY'
        }
    });

    $('#inputNations').typeahead(null, {
        name: 'nations',
        display: 'value',
        source: nations
    });

    $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
        checkData()
    });

    $("#inputServices").change(function() {
        checkData()
        
        if (this.value == 1) {
            $("#basic-addon-url").text("jasa-kirim-ekspor/");
        } else if (this.value == 2) {
            $("#basic-addon-url").text("jasa-kirim-impor/");
        } else {
            $("#basic-addon-url").text("");
        }
    })

    function checkData() {
        if ($('#inputServices').find(":selected").text() != 'Please Select' && $("#inputNationshidden").val() !== "") {
            $.ajax({
                url: '<?php echo Yii::$app->urlManager->createUrl('/content/check-data'); ?>',
                type: "POST",
                dataType: "json",
                data: {
                    idService: $('#inputServices').val(),
                    idNations: $("#inputNationshidden").val()
                },
                success: function(data) {
                    if (data.success) {
                        alert('Data sudah pernah di input');
                        $("#form-contens input, textarea, button").prop("disabled", true);
                    } else {
                        $("#form-contens input, textarea, button").prop("disabled", false);
                    }
                }
            })
        } else {
            $("#form-contens input, textarea, button").prop("disabled", false);
        }
    }

    $("#fileuploaddesktopbackground").fileupload({
        add: function(e, data) {
            var uploadErrors = [];
            var name = data.originalFiles[0]["name"];
            var lastDot = name.lastIndexOf('.');
            var ext = name.substring(lastDot + 1);
            var file, img;
            var _URL = window.URL || window.webkitURL;
            if ((file = data.files[0])) {
                img = new Image();
                var objectUrl = _URL.createObjectURL(file);
                img.onload = function () {
                    if(this.width != 1347 || this.height != 300){
                        alert('Dimensi Image harus 1347 x 300 px !!!');
                        return false;
                    }
                    _URL.revokeObjectURL(objectUrl);
                };
                img.src = objectUrl;
            }
            if (ext != 'jpg') {
                uploadErrors.push("Not an accepted file type, file type must be JPG");
            }

            if (uploadErrors.length > 0) {
                alert(uploadErrors.join("\n"));
            } else {
                $("#backgroundImagesDesktop").empty();
                data.context = $(
                    `
                    <div class="">
                        <h3>` + data.files[0].name + `</h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            
                            </div>
                        </div>
                    </div>
                    `
                ).appendTo("#backgroundImagesDesktop");
                data.url = "<?php echo Yii::$app->urlManager->createUrl('content/uploadimage'); ?>";
                data.dataType = "JSON";
                data.submit();
            }
        },
        progress: function(e, data) {
            var progress = parseInt((data.loaded / data.total) * 100, 10);
            data.context
                .find(".progress-bar")
                .text(progress + "%")
                .css("width", progress + "%");

            if (progress == 100) {
                $(".progress").remove();
            }
        },
        done: function(e, data) {
            if (data.result.success) {
                var file, img;
                var _URL = window.URL || window.webkitURL;
                if ((file = data.files[0])) {
                    img = new Image();
                    var objectUrl = _URL.createObjectURL(file);
                    img.onload = function () {
                        if(this.width != 1347 || this.height != 300){
                            // alert('Dimensi Image harus 1347 x 300 px !!!');
                            return false;
                        }
                        _URL.revokeObjectURL(objectUrl);
                    };
                    img.src = objectUrl;
                }
                $("#deleteImageBackgroundDesktop").remove();
                var btn = $(`
                        <button type="button" class="btn btn-danger" id="deleteImageBackgroundDesktop" data-id="` + data.result.name + `">delete</button>
                `)
                $("#inputBackgroundImagesDesktop").append(btn);
                $("#hiddenInputImageBackgroundDesktop").val(data.result.name);
                var base_url = window.location.origin;
                if (base_url == "http://localhost") {
                    $("#imgBackgroundDesktop").attr("src", base_url + "/kmp/frontend/web/images/banner/" + data.result.name);
                } else {
                    $("#imgBackgroundDesktop").attr("src", base_url + "/kmp/web/images/banner/" + data.result.name);
                }

            }
        },
        fail: function(e, data) {

        }
    })

    $("#fileuploadmobilebackground").fileupload({
        add: function(e, data) {
            var uploadErrors = [];
            var name = data.originalFiles[0]["name"];
            var lastDot = name.lastIndexOf('.');
            var ext = name.substring(lastDot + 1);
            if (ext != 'jpg') {
                uploadErrors.push("Not an accepted file type, file type must be JPG");
            }

            if (uploadErrors.length > 0) {
                alert(uploadErrors.join("\n"));
            } else {
                $("#backgroundImagesMobile").empty();
                data.context = $(
                    `
                    <div class="">
                        <h3>` + data.files[0].name + `</h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            
                            </div>
                        </div>
                    </div>
                    `
                ).appendTo("#backgroundImagesMobile");
                data.url = "<?php echo Yii::$app->urlManager->createUrl('content/uploadimagemobile'); ?>";
                data.dataType = "JSON";
                data.submit();
            }
        },
        progress: function(e, data) {
            var progress = parseInt((data.loaded / data.total) * 100, 10);
            data.context
                .find(".progress-bar")
                .text(progress + "%")
                .css("width", progress + "%");

            if (progress == 100) {
                $(".progress").remove();
            }
        },
        done: function(e, data) {
            if (data.result.success) {
                $("#deleteImageBackgroundMobile").remove();
                var btn = $(`
                        <button type="button" class="btn btn-danger" id="deleteImageBackgroundMobile" data-id="` + data.result.name + `">delete</button>
                `)
                $("#inputBackgroundImagesMobile").append(btn);
                $("#hiddenInputImageBackgroundMobile").val(data.result.name);
                var base_url = window.location.origin;
                if (base_url == "http://localhost") {
                    $("#imgBackgroundMobile").attr("src", base_url + "/kmp/frontend/web/images/banner/" + data.result.name);
                } else {
                    $("#imgBackgroundMobile").attr("src", base_url + "/kmp/web/images/banner/" + data.result.name);
                }

            }
        },
        fail: function(e, data) {

        }
    })
/* END SCRIPT TAB GENERAL */

</script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'Content[restriction][content]', {
        // filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        // filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
        // filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        // filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
    });
</script>