<?php


namespace backend\modules\admins\controllers;


use appxq\sdii\utils\VarDumper;
use appxq\sdii\widgets\SDDrawingv2;
use backend\lib\CNUtils;
use backend\models\PercentNewrich;
use yii\web\Controller;

class SettingController extends Controller
{
    public function beforeAction($action) {
        \Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex(){
        return $this->render('index',[]);
    }
    public function actionConfig(){
        return $this->render('config',[]);
    }

    public function actionGetData(){
        $model =  PercentNewrich::find()->one();
        return CNUtils::getSuccess($model,'สำเร็จ ');
    }
    /**
     * save data function
     */
    public function actionSaveData(){
       $post = \Yii::$app->request->post();
       if($post){
           $id = $post['id'];
           $model = PercentNewrich::findOne($id);
           if(!$model){
               $model = new PercentNewrich();
           }
           $model->totalPrice = $post['totalPrice'];
           $model->parentNewriched = $post['parentNewriched'];
           $model->customerPercent = $post['customerPercent'];
           $model->parentPercent = $post['parentPercent'];
           $model->percentPercent = $post['percentPercent'];
           $model->create_date = CNUtils::getCurrentDate();
           $model->create_by = CNUtils::getUserId();
           if($model->save()){
               return CNUtils::getSuccess($model, 'บันทึกสำเร็จ');
           }else{
               return CNUtils::getError($model->errors, 'บันทึกไม่สำเร็จ');
           }
       }
       VarDumper::dump($post);
    }

}