<?php


namespace backend\modules\admins\controllers;


use yii\web\Controller;

class SettingController extends Controller
{
    public function beforeAction($action) {
        \Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionConfig(){
        return $this->render('config',[]);
    }
}
    public function actionIndex(){
        return $this->render('index',[]);
    }

}