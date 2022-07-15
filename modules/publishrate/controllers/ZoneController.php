<?php

namespace app\modules\publishrate\controllers;

use app\models\Contents;
use app\models\PublishPriceCategory;
use app\models\PublishPriceZone;
use app\models\PublishPriceZoneSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ZoneController implements the CRUD actions for PublishPriceZone model.
 */
class ZoneController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
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

    /**
     * Lists all PublishPriceZone models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PublishPriceZoneSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PublishPriceZone model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = PublishPriceZone::find()
                        ->with([
                            'publishPriceCategory'
                        ])
                        ->where(['id' => $id])
                        ->one();
        $list = null;
        if(!empty($model->list_id_content)){
            $list = json_decode($model->list_id_content, TRUE);
        }
        
        return $this->render('view', [
            'model' => $model,
            'list' => $list
        ]);
    }

    /**
     * Creates a new PublishPriceZone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PublishPriceZone();
        $category = PublishPriceCategory::find()->all();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'category' => $category
        ]);
    }

    /**
     * Updates an existing PublishPriceZone model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category = PublishPriceCategory::find()->all();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'category' => $category
        ]);
    }

    /**
     * Deletes an existing PublishPriceZone model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PublishPriceZone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PublishPriceZone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PublishPriceZone::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionListCountryZone($id, $type){
        $model = PublishPriceZone::find()->select(['list_id_content'])->where(['id' => $id])->one();
        $tmp = json_decode($model->list_id_content, TRUE);
        $data['data'] = [];

        if(isset($tmp[$type])){
            $i = 0;
            foreach($tmp[$type] as $k => $v){
                $data['data'][$i]['id'] = $k;
                $data['data'][$i]['name'] = $v;
                $i++;
            }
        }
        die(json_encode($data));
    }

    public function actionListCountryNoneZone($type, $idcategory){
        if(!empty($type) && !empty($idcategory)){
            $idservice = ($type == 'export' ? 1 : 2);

            $model = PublishPriceZone::find()->where([
                'AND',
                ['id_publish_price_category' => $idcategory],
                ['IS NOT', 'list_id_content', null]
            ])->all();
            // echo "<pre>";print_r($model);
            if(!empty($model)){
                $_arr = [];
                foreach($model as $m){
                    $list = json_decode($m->list_id_content, TRUE);
                    if(!isset($list[$type])){
                        continue;
                    }else{
                        foreach($list[$type] as $k=>$v){
                            if(!in_array($k, $_arr)){
                                $_arr[] = $k;
                            }
                        }
                    }
                }

                // echo "<pre>";print_r($_arr);die;

                $data = Contents::find()
                                    ->alias('c')
                                    ->select([
                                        'c.id',
                                        'ct.name'
                                    ])
                                    ->joinWith([
                                        'country ct'
                                    ])
                                    ->where([
                                        'AND',
                                        ['not in', 'c.id', $_arr],
                                        ['c.id_services' => $idservice]
                                    ])
                                    ->orderBy('ct.name ASC')
                                    ->asArray()
                                    ->all();
                die('{"success":true, "data":'. json_encode($data).'}');
            }else{
                $data = Contents::find()
                ->alias('c')
                ->select([
                    'c.id',
                    'ct.name'
                ])
                ->joinWith([
                    'country ct'
                ])
                ->where([
                    'id_services' => $idservice
                ])
                ->orderBy('ct.name ASC')
                ->asArray()
                ->all();
                die('{"success":true, "data":'. json_encode($data).'}');
            }
        }
    }

    public function actionSaveCountryZone(){
        if(isset($_POST['type']) && isset($_POST['checkedValues']) && isset($_POST['id'])){
            $type = $_POST['type'];
            $id = $_POST['id'];
            $arr = [];
            foreach($_POST['checkedValues'] as $cv){
                $a = explode('-', $cv);
                $arr[$type][$a[0]] = $a[1]; 
            }
            $model = PublishPriceZone::findOne($id);
            if(!empty($model->list_id_content)){
                $list = json_decode($model->list_id_content, TRUE);
                if(isset($list[$type])){
                    $tmp = $list[$type];
                    unset($list[$type]);
                    $list[$type] = $tmp + $arr[$type];
                    $model->list_id_content = json_encode($list);
                }else{
                    $res = $list + $arr;
                    $model->list_id_content = json_encode($res);
                }
            }else{
                $model->list_id_content = json_encode($arr);
            }

            if($model->save()){
                die('{"success" : true}');
            }else{
                die('{"success" : false}');
            }
            echo json_encode($arr);
        }
    }

    public function actionRemoveCountryZone(){
        if(isset($_POST['id']) && isset($_POST['idcountry']) && isset($_POST['type'])){
            $id = $_POST['id'];
            $idcountry = $_POST['idcountry'];
            $type = $_POST['type'];
            $model = PublishPriceZone::findOne($id);
            $list = json_decode($model->list_id_content, TRUE);
            unset($list[$type][$idcountry]);
            $model->list_id_content = json_encode($list);
            if($model->save()){
                die('{"success" : true}');
            }else{
                die('{"success" : false}');
            }
        }
    }
}
