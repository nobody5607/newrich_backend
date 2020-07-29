<?php

namespace backend\modules\games\controllers;

use backend\modules\games\models\GameEvent;
use backend\modules\games\models\GameFile;
use yii\web\Controller;

/**
 * Default controller for the `games` module
 */
class DefaultController extends Controller
{
    public function beforeAction($action)
    {

        header('Access-Control-Allow-Origin: *');
        $this->enableCsrfValidation = false;
        return true;
    }
    public function actionIndex(){
        $this->layout ='@backend/views/layouts/admin.php';
        return $this->render('index');
    }
    public function actionEvent($parent_id)
    {
        $game = GameEvent::find()->where(['parent_id'=>$parent_id])->orderBy(['number'=>SORT_ASC])->all();
        return $this->render('event',[
            'game'=>$game
        ]);
    }

    public function actionShared(){
        $this->layout ='shared.php';
        //return $this->layout;
        $id = \Yii::$app->request->get('uuid');
        $path = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        $model = GameFile::find()->where(['uuid'=>$id])->one();
        $image = '';
        $msg='';
        
        if($model){
            $image = "{$path}/images/{$model->filename}";
            $msg = $model->msg;
        }

        
        return $this->render('shared',[
            'id'=>$id,
            'image'=>$image,
            'model'=>$model,
            'msg'=>$msg
        ]);
    }
    public function actionViewData(){
        $this->layout ='shared.php';
        //return $this->layout;
        $id = \Yii::$app->request->get('uuid');
        $path = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        $model = GameFile::find()->where(['uuid'=>$id])->one();
        $image = '';
        if($model){
            $image = "{$path}/images/{$model->filename}";
        }
        //return $image;
        return $this->render('view-data',[
            'id'=>$id,
            'image'=>$image,
            'model'=>$model
        ]);
    }
}