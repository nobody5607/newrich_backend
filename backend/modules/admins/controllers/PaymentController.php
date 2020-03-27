<?php

namespace backend\modules\admins\controllers;

use appxq\sdii\utils\VarDumper;
use backend\models\PaymentSearch;
use Yii;
use backend\modules\admins\models\Payment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
{

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (in_array($action->id, array('create', 'update', 'delete', 'index'))) {
                $this->layout = 'admin';
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new \backend\modules\admins\models\PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
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
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = new Payment();

            if ($model->load(Yii::$app->request->post())) {
                $model->rstat = 1;
                $model->create_date = date('Y-m-d H:i:s');
                $model->create_by = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';


                //$old_date = date('2020-03-25');
                //$next_due_date = date('Y-m-d', strtotime($old_date. " +{$model->amount} days"));
                //return $next_due_date;
                //VarDumper::dump($next_due_date);

                if ($model->save()) {
                    return \cpn\chanpan\classes\CNMessage::getSuccess('เพิ่มข้อมูลสำเร็จ');
                } else {
                    return \cpn\chanpan\classes\CNMessage::getError('เพิ่มข้อมูลไม่สำเร็จ');
                }
            } else {
                if (!isset($model->status)) {
                    $model->status = 0;
                }
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                $model->rstat = 1;
                $model->update_date = date('Y-m-d H:i:s');
                $model->update_by = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : '';

                //$old_date = date('2020-03-25');
                //$next_due_date = date('Y-m-d', strtotime($old_date. " +{$model->amount} days"));
                //return $next_due_date;
                //VarDumper::dump($next_due_date);
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

    /**
     * Deletes an existing Payment model.
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

                return \cpn\chanpan\classes\CNMessage::getSuccess('ลบข้อมูลสำเร็จ');
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('ลบข้อมูลไม่สำเร็จ');
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
