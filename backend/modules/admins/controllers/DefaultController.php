<?php

namespace backend\modules\admins\controllers;

use appxq\sdii\utils\VarDumper;
use backend\modules\core\classes\CoreFunc;
use common\models\Options;
use cpn\chanpan\classes\CNMessage;
use yii\web\Controller;

/**
 * Default controller for the `admins` module
 */
class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'edit-play-money' || $action->id == 'money-condition') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPricePackage(){
        $price = 0;
        if(isset(\Yii::$app->params['totalPrice'])){
            $price = \Yii::$app->params['totalPrice'];
        }

        if(\Yii::$app->request->post()){
            $price = \Yii::$app->request->post('price');
            $options = Options::find()->where(['label'=>'totalPrice'])->one();
            $options->value = $price;
            if($options->save()){
                return CNMessage::getSuccess("แก้ไขข้อมูลสำเร็จ");
            }else{
                return CNMessage::getError("แก้ไขข้อมูลไม่สำเร็จ");
            }
        }
        return $this->render("price-package",[
            'price'=>$price
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->getUser()->logout();
        return $this->goHome();
    }

    public function actionEditPlayMoney(){
        $ReceiveMoney = isset(\Yii::$app->params['ReceiveMoney'])?\Yii::$app->params['ReceiveMoney']:'';
        if(\Yii::$app->request->post('ReceiveMoney')){
            $model = Options::find()->where(['label'=>'ReceiveMoney'])->one();
            $model->value = \Yii::$app->request->post('ReceiveMoney');
            if($model->save()){
                return CNMessage::getSuccess("บันทึกข้อมูลสำเร็จ");
            }else{
                return CNMessage::getError("บันทึกข้อมูลไม่สำเร็จ");
            }
        }

        return $this->render('edit-play-money',[
            'ReceiveMoney'=>$ReceiveMoney
        ]);
    }

    public function actionMoneyCondition(){
        $money_condition = isset(\Yii::$app->params['money_condition'])?\Yii::$app->params['money_condition']:'';
        if(\Yii::$app->request->post('money_condition')){
            $model = Options::find()->where(['label'=>'money_condition'])->one();
            $model->value = \Yii::$app->request->post('money_condition');
            if($model->save()){
                return CNMessage::getSuccess("บันทึกข้อมูลสำเร็จ");
            }else{
                return CNMessage::getError("บันทึกข้อมูลไม่สำเร็จ");
            }
        }

        return $this->render('money-condition',[
            'money_condition'=>$money_condition
        ]);
    }
}
