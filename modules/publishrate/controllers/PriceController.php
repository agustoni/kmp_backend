<?php

namespace app\modules\publishrate\controllers;

use app\models\Contents;
use app\models\PublishPriceZone;

class PriceController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSubmitPublishPriceByZone()
    {
        if(isset($_POST['PublishPrice'])){
            $type = $_POST['PublishPrice']['type'];
            $id_publish_price_zone = $_POST['PublishPrice']['idpublishpricezone'];
            $publish_price_zone = PublishPriceZone::findOne($id_publish_price_zone);
            $category_name = strtolower($publish_price_zone->publishPriceCategory->name);
            if(!empty($publish_price_zone->list_id_content)){
                $list_id_content = json_decode($publish_price_zone->list_id_content, TRUE);
                if(isset($list_id_content[$type])){
                    $arr_rate = [];
                    foreach($_POST['PublishPrice']['rate'] as $rate){
                        $arr_rate[$category_name][$rate['tier']] = $rate['price'];
                    }
                    $list = $list_id_content[$type];
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        foreach($list as $k => $v){
                            $model = Contents::findOne($k);
                            $model->scenario = 'savepricepublish';
                            if(empty($model->price_publish)){
                                $model->price_publish = json_encode($arr_rate, JSON_UNESCAPED_UNICODE);
                            }else{
                                $tmp = json_decode($model->price_publish, TRUE);
                                unset($tmp[$category_name]);
                                $new_arr_rate = $tmp + $arr_rate;
                                $model->price_publish = json_encode($new_arr_rate, JSON_UNESCAPED_UNICODE);
                            }
                            if(!$model->save()){
                                throw new \Exception("Error Processing Request");
                            }
                        }
                        $transaction->commit();
                        die('{"success":true, "list_country":'.json_encode($list).'}');
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        die('{"success":false, "message":"'.$e->getMessage().'"}');
                    }
                }else{
                    die('{"success":false, "message":"List Country Not Available"}');
                }
            }else{
                die('{"success":false, "message":"List Country Not Available."}');
            }

        }
    }
}
