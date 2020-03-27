<?php

namespace backend\modules\admins\controllers;

use appxq\sdii\utils\VarDumper;
use backend\modules\admins\models\Profile;
use Yii;
use backend\modules\admins\models\User;
use backend\modules\admins\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    public function actionIndex()
    {

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
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

    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
            $model = Profile::find()->where(['user_id'=>$id])->one();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.');
                }
            } else {

                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }

    }


    public function actionDelete($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);

            if ($model->delete()) {

                return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
