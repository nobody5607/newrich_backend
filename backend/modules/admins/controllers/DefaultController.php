<?php

namespace backend\modules\admins\controllers;

use common\models\Options;
use cpn\chanpan\classes\CNMessage;
use yii\web\Controller;

/**
 * Default controller for the `admins` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
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
}
