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
            	return $this->redirect(['update', 'id'=>$id]);
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

    public function actionUploadimage(){
        if(!empty($_POST["Content"]["inputnations"])){
            $nation = Nations::findOne($_POST["Content"]["inputnations"]);
            $dir = strtolower($nation->Name);
        }else{
            $dir = 'default';
        }
        foreach($_FILES as $f){
            if (!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'../frontend/web/images/banner/'.$dir)) {
                mkdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'../frontend/web/images/banner/'.$dir, 0777, true);
            }
            
            $content = file_get_contents($f['tmp_name'][0]);
            $name = $f['name'][0];
            $im = new \Imagick();
            $im->readImageBlob($content);
            $im->resizeImage(1347,300, \Imagick::FILTER_LANCZOS, 0.9, true);
            $im->setImageCompressionQuality(50);
            $ret = $im->writeImage(dirname(__FILE__).DIRECTORY_SEPARATOR.'../frontend/web/images/banner/'.$dir."/".$name);
            
            if($ret){
                die('{"success":true, "name":"'.$dir.'/'.$name.'"}');
            }else{
                die('{"success":false}');
            }
        }
    }

    public function actionUploadimagemobile(){
        if(!empty($_POST["Content"]["inputnations"])){
            $nation = Nations::findOne($_POST["Content"]["inputnations"]);
            $dir = strtolower($nation->Name);
        }else{
            $dir = 'default';
        }
        foreach($_FILES as $f){
            if (!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'../frontend/web/images/banner/'.$dir)) {
                mkdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'../frontend/web/images/banner/'.$dir, 0777, true);
            }
            
            $content = file_get_contents($f['tmp_name'][0]);
            $name = "mobile-".$f['name'][0];
            $im = new \Imagick();
            $im->readImageBlob($content);
            $im->resizeImage(350,230, \Imagick::FILTER_LANCZOS, 0.9, true);
            $im->setImageCompressionQuality(60);
            $ret = $im->writeImage(dirname(__FILE__).DIRECTORY_SEPARATOR.'../frontend/web/images/banner/'.$dir."/".$name);
            
            if($ret){
                die('{"success":true, "name":"'.$dir.'/'.$name.'"}');
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
            $arrContent['desktopBanner'] = $post['Content']['imageDesktopBackground'];
            $arrContent['mobileBanner'] = $post['Content']['imageMobileBackground'];
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
            // if(!empty($post['Content']['welcome'])){
            //     foreach ($post['Content']['welcome'] as $k=>$v) {
            //         if($k != "video"){
            //             if(!empty($v['heading']) && !empty($v['content'])){
            //                 $arrWelcome[$k] = [];
            //                 $arrWelcome[$k]['heading'] = $v['heading'];
            //                 $arrWelcome[$k]['content'] = $v['content'];
            //             }
            //         }else{
            //             // echo dirname(__FILE__).DIRECTORY_SEPARATOR.'../..frontend/web/images/';die;
            //             if(!empty($v)){
            //                 $name = $v.".jpg";
            //                 $nameMobile = $v."-mobile.jpg";
            //                 // $image = file_get_contents("https://img.youtube.com/vi/".$v."/maxresdefault.jpg");
            //                 if(false === ($image = @file_get_contents("https://img.youtube.com/vi/".$v."/maxresdefault.jpg"))){
            //                     $image = file_get_contents("https://img.youtube.com/vi/".$v."/hqdefault.jpg");
            //                 }
            //                 $im = new \Imagick();
            //                 $im->readImageBlob($image);
            //                 $im->resizeImage(248,139, \Imagick::FILTER_LANCZOS, 0.9, true);
            //                 $im->setImageCompressionQuality(50);
            //                 $im->writeImage(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../frontend/web/images/yt-thumb/'.$name);

            //                 $imSmall = new \Imagick();
            //                 $imSmall->readImageBlob($image);
            //                 $imSmall->resizeImage(350,230, \Imagick::FILTER_LANCZOS, 0.9, true);
            //                 $imSmall->setImageCompressionQuality(50);
            //                 $imSmall->writeImage(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../frontend/web/images/yt-thumb/'.$nameMobile);
            //             }
            //             $arrWelcome[$k] = $v;
            //             $video = $v;
            //         }
            //     }
            //     $arrContent['welcome'] = $arrWelcome;
            // }

            // if(!empty($post['Content']['prohibitedItems'])){
            //     $arrContent['prohibitedItems'] = $post['Content']['prohibitedItems'];
            // }
            // if(!empty($post['Content']['documentationRequirements'])){
            //     $arrContent['documentationRequirements'] = $post['Content']['documentationRequirements'];
            // }
            // if(!empty($post['Content']['notes'])){
            //     $arrContent['notes'] = $post['Content']['notes'];
            // }
            // if(!empty($post['Content']['clearanceInformation'])){
            //     $arrContent['clearanceInformation'] = $post['Content']['clearanceInformation'];
            // }
            // if(!empty($post['Content']['gifts'])){
            //     $arrContent['gifts'] = $post['Content']['gifts'];
            // }

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
