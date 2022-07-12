<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use app\models\Countries;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller{
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
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate(){
        $model = new Post();
        $dataCountry = Countries::find()->all();

        if ($this->request->isPost) {
            $model->id_country = $_POST["Post"]["id_country"];
            $model->id_services = $_POST["Post"]["id_services"];
            $model->content = $_POST["Post"]["content"];
            $model->created_at = date("Y-m-d H:i:s");
            $model->created_by = Yii::$app->user->id;

            if($model->save()){
                Yii::$app->session->setFlash('success', "Article berhasil dibuat");
            }else{
                Yii::$app->session->setFlash('danger', "Article berhasil dibuat");
                print_r($model->getErrors());
            }

            return $this->redirect('create');
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'dataCountry' => $dataCountry
        ]);
    }

    public function actionUpdate($id){
        $model = $this->findModel($id);
        $dataCountry = Countries::find()->all();

        if ($this->request->isPost) {
            $model->content = $_POST["Post"]["content"];
            $model->created_at = date("Y-m-d H:i:s");
            $model->created_by = Yii::$app->user->id;

            if($model->save()){
                Yii::$app->session->setFlash('success', "Article berhasil dibuat");
            }else{
                Yii::$app->session->setFlash('danger', "Article berhasil dibuat");
                print_r($model->getErrors());
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataCountry' => $dataCountry
        ]);
    }

    public function actionDelete($id){
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id){
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCheckData(){
        if(isset($_POST['id_country']) && isset($_POST['id_service'])){
            $model = Post::find()->where(['id_country'=>$_POST['id_country'], 'id_services'=>$_POST['id_service']])->exists();
            if($model){
                die('{"success":true}');
            }else{
                die('{"success":false}');
            }
        }
    }
}
