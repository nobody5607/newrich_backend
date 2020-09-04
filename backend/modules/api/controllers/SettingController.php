<?php


namespace backend\modules\api\controllers;


use appxq\sdii\utils\VarDumper;
use backend\models\Bankitem;
use backend\models\Connectbank;
use backend\models\CreateBusines;
use backend\models\CreateGroup;
use backend\models\GroupUser;
use backend\models\Refund;
use backend\models\Slider;
use backend\models\StatusPayment;
use backend\models\Withdraw;
use backend\modules\admins\models\Payment;
use backend\modules\admins\models\Profile;
use backend\modules\api\models\Orders;
use common\modules\user\models\User;
use cpn\chanpan\classes\CNMessage;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class SettingController extends Controller
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

    //image slider
    public function actionSlider()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $slider = Slider::find()->all();
        if ($slider) {
            $output = [];
            $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
            foreach ($slider as $k => $v) {
                $output[] = ['id' => $v->id, 'order' => $v->order, 'image' => "{$storageUrl}/images/{$v->image}"];
            }
            return $output;
        }
    }

    public function getUserByToken($token)
    {
        $user = \backend\modules\admins\models\User::find()->where(['auth_key' => $token])->one();
        return $user;
    }

    public function actionBusinessGroup()
    {
        $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $groupUser = GroupUser::find()->where(['user_id' => $user->id])->all();
        $group_id = [];
        if ($groupUser) {
            foreach ($groupUser as $k => $v) {
                $group_id[] = $v->group_id;
            }
        }
        $group = CreateGroup::find()->where(['id' => $group_id])->orWhere(['createBy' => $user->id])->orderBy(['id' => SORT_DESC])->all();
        foreach ($group as $k => $v) {
            $v['image'] = "{$storageUrl}{$v->image}";
            //$output[] = $v;
        }
        return $group;

    }

    public function actionBusinessDetail($id)
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        $bussiness = CreateBusines::find()->where(['groupID' => $id])->all();
        $output = [];

        if ($bussiness) {

            foreach ($bussiness as $k => $v) {
                $output[] = [
                    'id' => $v->id,
                    'isCollapsed' => true,
                    'title' => $v->title,
                    'detail' => $v->detail,
                    'createBy' => $v->createBy,
                    'createDate' => $v->createDate,
                    'orderBy' => $v->orderBy,
                    'groupID' => $v->groupID,

                ];
            }
            return $output;
        }
    }


    public function actionAccept()
    {
        $accept = isset(\Yii::$app->params['accept']) ? \Yii::$app->params['accept'] : '';
        return ['message' => $accept];
    }

    public function getUploadPath()
    {
        return \Yii::getAlias('@storage') . '/web/images/';
    }

    public function actionPreviewPayment()
    {
        $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $model = Payment::find()->where(['user_id' => $user->id])->orderBy(['id' => SORT_DESC])->one();
        if ($model) {
            return "{$storageUrl}/{$model->image}";
        }
        return "{$storageUrl}/noimage.png";
    }

    public function actionUploadPayment()
    {
        \Yii::$app->controller->enableCsrfValidation = false;
        $path = $this->getUploadPath();
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $user_id = \Yii::$app->request->post('user_id');
            $fileName = md5($file->baseName . time()) . '.' . $file->extension;
            if ($file->saveAs($path . $fileName)) {
                $model = new Payment();
                $model->image = $fileName;
                $model->user_id = $user_id;
                $model->uploadDate = date('Y-m-d H:i:s');
                $model->status = 0;

                if ($model->save()) {
                    return $model;
                } else {
                    return $model->errors;
                }

//                return $file;
            }
        }
    }

    public function actionStatusPayment()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $model = StatusPayment::find()->where(['user_id' => $user->id])->one();

        if ($model) {
            $date1 = date_create(date('Y-m-d'));
            $date2 = date_create($model->expireDate);
            $diff = date_diff($date1, $date2);
            //$date = $diff->format("%R%a");
            $operatorDate = $diff->format("%R");
            if ($operatorDate == '+') {
                return true;
            }
            return false;

        } else {
            return false;
        }

    }

    public function actionAddRefund()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        $order_id = \Yii::$app->request->post('order_id');
        $amount = \Yii::$app->request->post('amount');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $model = new Refund();
        $model->user_id = $user->id;
        $model->order_id = $order_id;
        $model->amount = $amount;

        if ($model->save()) {
            return $model;
        } else {
            return $model->errors;
        }
    }

    public function actionGetBank($user_id)
    {

        $model = Connectbank::find()->where(['user_id' => $user_id])->one();
        if ($model) {
            $model->bank = $model->banks->name;
        }
        return $model;
    }
    public function actionSavePin(){
        $token = \Yii::$app->request->headers->get('x-access-token');
        $pin = \Yii::$app->request->post('pin');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $profile = Profile::findOne($user->id);
        $profile->pin = $pin;
        if($profile->save()){
            return true;
        }else{
            return false;
        }
    }
    public function actionWithdraw()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        $amount = \Yii::$app->request->post('amount');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $model = new Withdraw();
        $model->user_id = $user->id;
        $model->amount = $amount;
        $model->createDate = date('Y-m-d H:i:s');
        if($model->save()){
            $profile = Profile::findOne($user->id);
            $order = Orders::find()->where(['user_id'=>$profile->member_id])->all();
            if($order){
                foreach($order as $k=>$v){
                    $v->payment = 20; //รอการอนุมัติ
                    $v->save();
                }
            }
            return true;
        }else{
            return false;
        }


    }

    public function actionSaveBank()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        $accountType = \Yii::$app->request->post('accountType');
        $accountNumber = \Yii::$app->request->post('accountNumber');
        $accountName = \Yii::$app->request->post('accountName');
        $id = \Yii::$app->request->post('id','');

        $active = \Yii::$app->request->post('active');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);

        $check = Connectbank::find()->select('count(*)')->where(['user_id'=>$user->id])->scalar();
        if($check > 3){
            return CNMessage::getError("คุณสามารเพิ่มได้แค่ 3 รายการเท่านั้น");
        }

        if($id != ''){
            $model = Connectbank::findOne($id);
        }else{
            $model = new Connectbank();
        }

        $model->user_id= $user->id;
        $model->name= $accountName;
        $model->account= $accountNumber;
        $model->bank= $accountType;
        $model->active = $active;
        $x=Connectbank::find()->where(['user_id'=>$user->id])->all();
        if($x){
            foreach($x as $k=>$v){
                $v->active = 0;
                $v->save();
            }
        }
        if($model->save()){
            return CNMessage::getSuccess("สำเร็จ");
        }else{
            return CNMessage::getError("ไม่สำเร็จ");
        }
    }
    public function actionGetBanks(){
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        $model = Connectbank::find()->where(['user_id'=>$user->id])->orderBy(['active'=>SORT_DESC])->all();
        if($model){
            foreach($model as $k=>$v){
                $bankItem = Bankitem::find()->where(['id'=>$v->bank])->one();
                $v->bank = $bankItem->name;
            }
        }
        return CNMessage::getSuccess("สำเร็จ", $model);
    }


}
