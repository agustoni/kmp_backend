<?php

namespace app\controllers;

use Yii;
use app\models\Contents;
use app\models\ContentsSearch;
use app\models\Countries;
use app\models\PublishPriceCategory;
use app\models\PublishPriceZone;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\db\Query;

class ContentController extends Controller{
    public function behaviors(){
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(){
        $searchModel = new ContentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id){
        $model = Contents::find()->where(['id' => $id])->one();
        $arr_content = json_decode($model->content, TRUE);
        $arr_publish_price = json_decode($model->price_publish, TRUE);
        $arr_price = json_decode($model->price, TRUE);

        $country_category_zone = \Yii::$app->db->createCommand("
                    SELECT b.id, b.id_publish_price_category, ppc.name as category_name, b.zone, JSON_UNQUOTE(b.res) as country 
                    FROM
                        (SELECT a.id, a.id_publish_price_category, a.zone, JSON_EXTRACT(a.result, '$.".$model->id."') as res 
                            FROM
                                (SELECT id, id_publish_price_category, zone, JSON_EXTRACT(list_id_content, '$.".strtolower($model->services->name)."') AS 'Result' 
                                    FROM 
                                        ".PublishPriceZone::tableName()." ) as a) as b
                    LEFT JOIN ".PublishPriceCategory::tableName()." ppc
                        ON ppc.id = b.id_publish_price_category
                    WHERE b.res IS NOT NULL
                ")->queryAll();
        // var_dump($country_category_zone);die;
        // echo "<pre>";print_r($country_category_zone);die;
        return $this->render('view', compact('model', 'arr_content', 'country_category_zone', 'arr_publish_price'));
    }

    public function actionCreate(){
        $model = new Contents();

        if (isset($_POST['Content'])) {
        	if($this->saveModel($model, $_POST, 'create')){
            	Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            	return $this->redirect(['index']);
            }else{
            	Yii::$app->session->setFlash('danger', 'Data gagal disimpan!');
            	return $this->redirect(['create']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){
        $model = $this->findModel($id);

        // if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'Id' => $model->Id]);
        // }

        if (isset($_POST['Content'])) {
        
            if($this->saveModel($model, $_POST, 'update')){
            	Yii::$app->session->setFlash('success', 'Data berhasil diupdate');
            	return $this->redirect(['index']);
            }else{
            	Yii::$app->session->setFlash('danger', 'Data gagal diupdate!');
            	return $this->redirect(['update', 'id'=>$id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionGetNations($q){
        $data = Countries::find()->where('name LIKE "%' . $q .'%"')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['id' => $d['id'], 'value' => $d['name']];
        }
        echo Json::encode($out);
        die;
    }

    public function actionCheckData(){
        if(isset($_POST['idService']) && isset($_POST['idNations'])){
            $model = Contents::find()->where(['id_country'=>$_POST['idNations'], 'id_services'=>$_POST['idService']])->exists();
            
            if($model){
                die('{"success":true}');
            }else{
                die('{"success":false}');
            }
        }
    }

    public function saveModel($model, $post, $type){
        // print_r($post);die;
        $content = null;
        $arrPriceList = [];
        $arrWelcome = [];
        $arrContent = [];
        $video = null;

        if(!empty($post['Content']['inputnations']) || !empty($post['Content']['inputservices'])){
            $arrContent['meta'] = $post['Content']['meta'];
            // $arrContent['listkota'] = $post['Content']['listkota'];
            // $arrContent['welcome'] = $post['Content']['welcome'];
            // if(!empty($post['Content']['pdf'])){
            //     $arrContent['pdf'] = $post['Content']['pdf'];
            // }
            if(!empty($post['Content']['tax'])){
                $arrContent['tax'] = $post['Content']['tax'];
            }
            if(!empty($post['Content']['restriction'])){
                $arrContent['restriction'] = $post['Content']['restriction'];
            }

            $content = json_encode($arrContent, JSON_UNESCAPED_UNICODE);
            
            $model->id_country = $_POST['Content']['inputnations'];
            $model->id_services = $_POST['Content']['inputservices'];
            $model->slug = str_replace(' ','',$_POST['Content']['slug']);
            $model->content = $content;
            $model->status = ($type == 'create' ? 0:1);
            $model->created_by = Yii::$app->user->id;
            $model->created_at = date("Y-m-d H:i:s");
            // $model->Video = !empty($video) ? $video : null;
            if($model->save()){
                // Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
                // return $this->redirect(['index']);

                return true;
            }else{
                Yii::$app->session->setFlash('error', 'Gagal menyimpan data');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionDelete($Id){
        $this->findModel($Id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id){
        if (($model = Contents::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
