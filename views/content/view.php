<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contents */

$this->title = $model->country->name. " - ".$model->services->name;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contents-view">
    <div class="row mt-3">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <section id="section-action">
        <div class="row">
            <div class="col-12">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </section>
    <section id="section-meta-tag">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Meta Tag</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th>Title</th>
                                            <td><?= $arr_content['meta']['title'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Keyword</th>
                                            <td><?= $arr_content['meta']['keyword'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td><?= $arr_content['meta']['description'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>H1</th>
                                            <td><?= $arr_content['meta']['h1'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>H2</th>
                                            <td><?= $arr_content['meta']['h2'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="section-publish-rate">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Publish Price</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php 
                            if($country_category_zone){ 
                                foreach($country_category_zone as $ccz){ ?>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6>Kategori <?= $ccz["category_name"] ?> Zona <?= $ccz["zone"] ?></h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php if(isset($arr_publish_price) && !empty($arr_publish_price[strtolower($ccz["category_name"])])){ ?>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tier</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($arr_publish_price[strtolower($ccz["category_name"])] as $tier => $price){ ?>
                                                                    <tr>
                                                                        <td><?= $tier ?></td>
                                                                        <td><?= $price ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php }else{ ?>
                                                            <p><i>Price not yet set</i></p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            }else{ ?>
                            <div class="col">
                                <p><i>Zone not yet set</i></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
