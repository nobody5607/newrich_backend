<?php


namespace backend\modules\games\controllers;


use backend\modules\admins\models\Payment;
use backend\modules\games\models\GameEvent;
use backend\modules\games\models\GameFile;
use backend\modules\games\models\GameScore1;
use yii\web\Controller;
use yii\web\UploadedFile;

class ApiController extends Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $origin = "*";
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        header("Access-Control-Allow-Origin: $origin", true);
        header("Access-Control-Allow-Headers: Origin,Content-Type,Authorization,x-access-token,application,uuid,version,platform");
        $this->enableCsrfValidation = false;
        return true;
    }
    public function actionGetGame($parent_id){
        $this->layout = 'main2';
        $game = GameEvent::find()->where(['parent_id'=>$parent_id])->orderBy(['number'=>SORT_ASC])->all();
        return $game;
    }
    public function actionSaveScore1(){
        $parentId = \Yii::$app->request->post('parent_id');
        $n1 = \Yii::$app->request->post('n1');
        $n2 = \Yii::$app->request->post('n2');
        $n3 = \Yii::$app->request->post('n3');
        $n4 = \Yii::$app->request->post('n4');
        $n5 = \Yii::$app->request->post('n5');
        $n6 = \Yii::$app->request->post('n6');
        $n7 = \Yii::$app->request->post('n7');
        $n8 = \Yii::$app->request->post('n8');
        $score = \Yii::$app->request->post('score');
        $model = new GameScore1();
        $model->parent_id = $parentId;
        $model->n1 = $n1;
        $model->n2  = $n2;
        $model->n3 = $n3;
        $model->n4 = $n4;
        $model->n5 = $n5;
        $model->n6 = $n6;
        $model->n7 = $n7;
        $model->n8 = $n8;
        $model->score = $score;
        $model->createDate = date('Y-m-d H:i:s');
        if($model->save()){
            return true;
        }
        return false;
    }
    public function getUploadPath()
    {
        return \Yii::getAlias('@storage') . '/web/images/';
    }
    public function actionUploadImage()
    {
        $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        \Yii::$app->controller->enableCsrfValidation = false;
        $path = $this->getUploadPath();
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $msg = \Yii::$app->request->post('msg');
            $fileName = md5($file->baseName . time()) . '.' . $file->extension;
            if ($file->saveAs($path . $fileName)) {
                $model = new GameFile();
                $model->filename = $fileName;
                $model->createDate = date('Y-m-d H:i:s');
                $model->msg = $msg;
                if ($model->save()) {
                    return "{$storageUrl}/images/{$model->filename}";
                } else {
                    return $model->errors;
                }

//                return $file;
            }
        }
    }
}
