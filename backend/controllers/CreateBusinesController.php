<?php

namespace backend\controllers;

use appxq\sdii\utils\VarDumper;
use Yii;
use backend\models\CreateBusines;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * CreateBusinesController implements the CRUD actions for CreateBusines model.
 */
class CreateBusinesController extends Controller
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
     * Lists all CreateBusines models.
     * @return mixed
     */
    public function actionIndex($groupId)
    {
        VarDumper::dump($groupId);
        $dataProvider = new ActiveDataProvider([
            'query' => CreateBusines::find()->where(['groupID'=>$groupId]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CreateBusines model.
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
     * Creates a new CreateBusines model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = new CreateBusines();

            if ($model->load(Yii::$app->request->post())) {
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
     * Updates an existing CreateBusines model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('แก้ไขข้อมูลสำเร็จ');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.');
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

    /**
     * Deletes an existing CreateBusines model.
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
     * Finds the CreateBusines model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CreateBusines the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CreateBusines::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
