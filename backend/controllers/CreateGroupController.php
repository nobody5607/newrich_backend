<?php

namespace backend\controllers;

use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\VarDumper;
use common\modules\user\classes\CNUserFunc;
use Yii;
use backend\models\CreateGroup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

class CreateGroupController extends Controller
{

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (in_array($action->id, array('create', 'update', 'delete', 'index'))) {

            }
            return true;
        } else {
            return false;
        }
    }

    public function actionIndex($token='', $site='')
    {
        //return $token;
        if(empty(Yii::$app->session['site'])){
            Yii::$app->session['site'] = $site;
        }
        $user = CNUserFunc::getUserByToken($token);
        if(empty(\Yii::$app->session['token'])){
            \Yii::$app->session['token'] = $token;
        }
        if(empty(\Yii::$app->session['user_id'])){
            \Yii::$app->session['user_id'] = $user->id;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => CreateGroup::find()
                ->where(['createBy'=>$user->id])
                ->orderBy(['orderBy' => SORT_ASC]),
        ]);

        //VarDumper::dump(\Yii::$app->session['user_id']);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = new CreateGroup();
            $model->createBy = isset(\Yii::$app->session['user_id'])?\Yii::$app->session['user_id']:'';
            $model->createDate = date('Y-m-d H:i:s');
            $model->site = isset(Yii::$app->session['site'])?Yii::$app->session['site']:'';
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('เพิ่มข้อมูลสำเร็จ');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('เพิ่มข้อมูลไม่สำเร็จ');
                }
            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                $model->site = isset(Yii::$app->session['site'])?Yii::$app->session['site']:'';
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('แก้ไขข้อมูลสำเร็จ');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('แก้ไขข้อมูลไม่สำเร็จ');
                }
            } else {
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);
            if ($model->delete()) {

                return \cpn\chanpan\classes\CNMessage::getSuccess('ลบข้อมูลสำเร็จ');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('ลบข้อมูลไม่สำเร็จ');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    protected function findModel($id)
    {
        if (($model = CreateGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
