<?php


namespace backend\modules\admins\controllers;


use yii\web\Controller;

class SettingController extends Controller
{
    public function actionIndex(){
//        return 'ok';
        return $this->render('index',[]);
    }

}
