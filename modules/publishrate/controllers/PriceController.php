<?php

namespace app\modules\publishrate\controllers;

use app\models\Contents;
use app\models\PublishPriceCategory;
use app\models\PublishPriceZone;

class PriceController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPublishPriceByCategoryZone(){
        return $this->render('publish-price-by-category-zone');
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

    public function actionPublishPriceByContent($idcontent){
        $content = Contents::find()->where(['id' => $idcontent])->one();
        $arr_publish_price = json_decode($content->price_publish, TRUE);
        $category = PublishPriceCategory::find()->all();
        $country_category_zone = \Yii::$app->db->createCommand("
                    SELECT b.id, b.id_publish_price_category, ppc.name as category_name, b.zone, JSON_UNQUOTE(b.res) as country 
                    FROM
                        (SELECT a.id, a.id_publish_price_category, a.zone, JSON_EXTRACT(a.result, '$.".$content->id."') as res 
                            FROM
                                (SELECT id, id_publish_price_category, zone, JSON_EXTRACT(list_id_content, '$.".strtolower($content->services->name)."') AS 'Result' 
                                    FROM 
                                        ".PublishPriceZone::tableName()." ) as a) as b
                    LEFT JOIN ".PublishPriceCategory::tableName()." ppc
                        ON ppc.id = b.id_publish_price_category
                    WHERE b.res IS NOT NULL
                ")->queryAll();
        $arr_country_zone = [];
        // echo "<pre>";print_r($country_category_zone);die;
        if(!empty($country_category_zone)){
            foreach($country_category_zone as $ccz){
                $arr_id_category_zone[] = $ccz['id'];
            }

            $publish_price_zone = PublishPriceZone::find()->where(['id' => $arr_id_category_zone])->all();
            $arr_country_zone[$ccz['id_publish_price_category']] = [];
            foreach($publish_price_zone as $ppz){
                $list_id_content = json_decode($ppz->list_id_content, TRUE);

                $arr_country_zone[$ppz->id_publish_price_category] = $list_id_content[strtolower($content->services->name)];
                
            }
            ksort($arr_country_zone);
        }
        return $this->render('publish-price-by-content', compact('content', 'category', 'arr_publish_price', 'arr_country_zone'));
    }

    public function actionSubmitPublishPriceByContent(){
        if(isset($_POST['PublishPrice'])){
            $id_content = $_POST['PublishPrice']['idcontent'];
            $category_name = $_POST['PublishPrice']['category'];
            $arr_rate = [];
            foreach($_POST['PublishPrice']['rate'] as $rate){
                $arr_rate[$category_name][$rate['tier']] = $rate['price'];
            }
            $model = Contents::findOne($id_content);
            if(empty($model->price_publish)){
                $model->price_publish = json_encode($arr_rate, JSON_UNESCAPED_UNICODE);
            }else{
                $tmp = json_decode($model->price_publish, TRUE);
                unset($tmp[$category_name]);
                $new_arr_rate = $tmp + $arr_rate;
                $model->price_publish = json_encode($new_arr_rate, JSON_UNESCAPED_UNICODE);
            }

            if($model->save()){
                die('{"success":true}');
            }else{
                die('{"success":false}');
            }
        }
    }

    public function actionSubmitPriceWithSameZone(){
        if(isset($_POST['category_name']) && isset($_POST['id_content']) && isset($_POST['checkedValues'])){
            $category_name = $_POST['category_name'];
            $id_content = $_POST['id_content'];
            $arr = [];
            foreach($_POST['checkedValues'] as $cv){
                $a = explode('-', $cv);
                $arr[$a[0]] = $a[1]; 
            }

            $model = Contents::find()->where(['id' => $id_content])->one();
            $publish_price = json_decode($model->price_publish, TRUE);
            if(isset($publish_price[$category_name])){
                $publish_price_category[$category_name] = $publish_price[$category_name];
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    foreach($arr as $k => $v){
                        $target_model = Contents::findOne($k);
                        $target_publish_price = json_decode($target_model->price_publish, TRUE);
                        if(empty($target_publish_price)){
                            $target_model->price_publish = json_encode($publish_price_category, JSON_UNESCAPED_UNICODE);
                        }else{
                            $tmp = json_decode($target_model->price_publish, TRUE);
                            unset($tmp[$category_name]);
                            $new_arr = $tmp + $publish_price_category;
                            $target_model->price_publish = json_encode($new_arr, JSON_UNESCAPED_UNICODE);
                        }
                        if(!$target_model->save()){
                            throw new \Exception("Failed Update Price To Selected Country");
                        }
                    }
                    $transaction->commit();
                    die('{"success":true}');
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    die('{"success":false, "message":"'.$e->getMessage().'"}');
                }
            }else{
                die('{"success":false, "message":"Content doesn`t have price"}');
            }
        }
    }
}
