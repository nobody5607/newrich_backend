<?php

namespace backend\controllers;

use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\VarDumper;
use backend\models\Connectbank;
use backend\models\CreateBusines;
use backend\models\GroupUser;
use backend\models\SendMail;
use backend\models\Withdraw;
use backend\modules\admins\models\Profile;
use backend\modules\admins\models\User;
use common\modules\user\classes\CNUserFunc;
use cpn\chanpan\classes\CNMessage;
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

    public function actionIndex($token = '', $site = '')
    {

        $this->layout = 'main2';
        //return $token;
        if (empty(Yii::$app->session['site'])) {
            Yii::$app->session['site'] = $site;
        }
        $user = CNUserFunc::getUserByToken($token);
        if (empty(\Yii::$app->session['token'])) {
            \Yii::$app->session['token'] = $token;
        }
        if (empty(\Yii::$app->session['user_id'])) {
            \Yii::$app->session['user_id'] = $user['id'];
        }


        $dataProvider = new ActiveDataProvider([
            'query' => CreateGroup::find()
                ->where(['createBy' => $user->id])
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
            $model->createBy = isset(\Yii::$app->session['user_id']) ? \Yii::$app->session['user_id'] : '';
            $model->createDate = date('Y-m-d H:i:s');
            $model->site = isset(Yii::$app->session['site']) ? Yii::$app->session['site'] : '';
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $creareGroup = new GroupUser();
                    $creareGroup->group_id = $model->id;
                    $creareGroup->user_id = $model->createBy;
                    $creareGroup->create_by = $model->createBy;
                    $creareGroup->create_date = date('Y-m-d H:i:s');
                    $creareGroup->rstat = 1;
                    $creareGroup->save();
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
                $model->site = isset(Yii::$app->session['site']) ? Yii::$app->session['site'] : '';
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

            $groupUser = GroupUser::find()->where(['group_id' => $model->id])->all();
            foreach ($groupUser as $k => $v) {
                $v->delete();
            }

            if ($model->delete()) {
                $bussiness = CreateBusines::find()
                    ->where('groupID=:groupID', [
                        ':groupID' => $id
                    ])->all();
                foreach ($bussiness as $k => $v) {
                    $v->delete();
                }
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

    public function actionSendMail($id)
    {
        $this->layout = 'main2';
        $user = User::findOne($id);
        $model = new SendMail();
        if ($model->load(Yii::$app->request->post())) {
            //VarDumper::dump($model);
            $model->setForm = ['chanpan.nuttaphon@gmail.com' => 'Newriched'];
            if ($model->sendMail()) {
                return CNMessage::getSuccess("ส่ง Email สำเร็จ");
            } else {
                return CNMessage::getError("ส่ง Email ไม่สำเร็จกรุณาลองใหม่ภายหลัง");
            }

        }
        $model->email = $user->email;
        return $this->render('send-mail', [
            'model' => $model,
            'user' => $user
        ]);
    }

    public function actionConnectBack($user_id)
    {
        $this->layout = 'main2';
        $model = Connectbank::find()->where(['user_id'=>$user_id])->one();
        if(!$model){
            $model = new Connectbank();
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return CNMessage::getSuccess('บันทึกรายการสำเร็จ');
            }else{
                return CNMessage::getError('บันทึกรายการไม่สำเร็จกรุณาลองใหม่อีกครั้งค่ะ');
            }
        }
        //return 'ok';
        $model->user_id = $user_id;
        return $this->render('connect-bank',[
           'model'=>$model
        ]);
    }
    public function actionHistory($user_id){
        $this->layout = 'main2';
        $model = Withdraw::find()->where(['user_id'=>$user_id])->orderBy(['createDate'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('history',[
            'dataProvider'=>$dataProvider
        ]);
        //VarDumper::dump($model);
    }

    public function actionMoneyCondition(){
        $this->layout = 'main2';
        $data = isset(\Yii::$app->params['money_condition'])?\Yii::$app->params['money_condition']:'';
       // VarDumper::dump($data);
        return $this->render('money-condition',[
            'data'=>$data
        ]);
    }

    public function actionReceiveMoney(){
        $this->layout = 'main2';
        $data = isset(\Yii::$app->params['ReceiveMoney'])?\Yii::$app->params['ReceiveMoney']:'';
        // VarDumper::dump($data);
        return $this->render('money-condition',[
            'data'=>$data
        ]);
    }

    public function actionProfile($user_id){
        $this->layout = 'main2';
        //$model = User::findOne($user_id);
        $model = Profile::findOne($user_id);
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return CNMessage::getSuccess('บันทึกรายการสำเร็จ');
            }else{
                return CNMessage::getError('บันทึกรายการไม่สำเร็จกรุณาลองใหม่อีกครั้งค่ะ');
            }
        }
        return $this->render('profile',[
            'model'=>$model,
        ]);
    }
}
