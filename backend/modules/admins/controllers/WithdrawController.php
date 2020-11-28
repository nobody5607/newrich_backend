<?php

namespace backend\modules\admins\controllers;

use backend\lib\CNUtils;
use Yii;
use backend\modules\admins\models\Withdraw;
use backend\modules\admins\models\WithdrawSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WithdrawController extends Controller
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

    /**
     * Lists all Withdraw models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Withdraw model.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Creates a new Withdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = new Withdraw();

            if ($model->load(Yii::$app->request->post())) {
                $model->rstat = 1;
                $model->create_date = date('Y-m-d H:i:s');
                $model->create_by = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
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

    /**
     * Updates an existing Withdraw model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                $model->rstat = 1;
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_by = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';
                $model->approveBy = CNUtils::getUserId();
                $model->approveDate = CNUtils::getCurrentDate();
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.');
                }
            } else {
                if($model->status == ''){
                    $model->status = 0;
                }
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

    }

    /**
     * Deletes an existing Withdraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);
            $model->rstat = 3;
            $model->update_date = date('Y-m-d H:i:s');
            $model->update_by = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';
            if ($model->save()) {

                return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDeletes()
    {
        if (Yii::$app->getRequest()->isAjax) {

            if (isset($_POST['selection'])) {
                foreach ($_POST['selection'] as $id) {
                    $model = $this->findModel($id);
                    $model = $this->findModel($id);
                    $model->rstat = 3;
                    $model->update_date = date('Y-m-d H:i:s');
                    $model->update_by = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';
                    $model->save();
                }
                return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.');
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Finds the Withdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Withdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Withdraw::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
