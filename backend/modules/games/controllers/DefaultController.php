<?php

namespace backend\modules\games\controllers;

use backend\modules\games\models\GameEvent;
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
    public function actionEvent($parent_id)
    {
        $game = GameEvent::find()->where(['parent_id'=>$parent_id])->orderBy(['number'=>SORT_ASC])->all();
        return $this->render('event',[
            'game'=>$game
        ]);
    }
}
