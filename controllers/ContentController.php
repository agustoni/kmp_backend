<?php

namespace app\controllers;

use Yii;
use app\models\Contents;
use app\models\ContentSearch;
use app\models\Nations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($Id){
        return $this->render('view', [
            'model' => $this->findModel($Id),
        ]);
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

    public function actionUpdate($Id){
        $model = $this->findModel($Id);

        // if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'Id' => $model->Id]);
        // }

        if (isset($_POST['Content'])) {
        
            if($this->saveModel($model, $_POST, 'update')){
            	Yii::$app->session->setFlash('success', 'Data berhasil diupdate');
            	return $this->redirect(['index']);
            }else{
            	Yii::$app->session->setFlash('danger', 'Data gagal diupdate!');
            	return $this->redirect(['update', 'id'=>$Id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionGetNations($q){
        $data = Nations::find()->where('Name LIKE "%' . $q .'%"')->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['id' => $d['Id'], 'value' => $d['Name']];
        }
        echo Json::encode($out);
        die;
    }

    public function actionCheckData(){
        if(isset($_POST['idService']) && isset($_POST['idNations'])){
            $model = Contents::find()->where(['Id_Nations'=>$_POST['idNations'], 'Id_Services'=>$_POST['idService']])->exists();
            
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
            
            $model->Id_Nations = $_POST['Content']['inputnations'];
            $model->Id_Services = $_POST['Content']['inputservices'];
            $model->Slug = str_replace(' ','',$_POST['Content']['slug']);
            $model->Content_Ind = $content;
            $model->Status = ($type == 'create' ? 0:1);
            $model->CreatedBy = Yii::$app->user->id;
            $model->Created = date("Y-m-d H:i:s");
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

    protected function findModel($Id){
        if (($model = Contents::findOne(['Id' => $Id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
