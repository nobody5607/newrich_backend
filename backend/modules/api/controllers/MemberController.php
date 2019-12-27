<?php

namespace backend\modules\api\controllers;

use appxq\sdii\utils\VarDumper;
use backend\modules\api\classes\ClsAccessCoss;
use backend\modules\api\classes\ClsOrder;
use common\modules\user\models\User;
use cpn\chanpan\classes\CNMessage;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Default controller for the `api` module
 */
class MemberController extends Controller
{
    public function beforeAction($action)
    {
        $origin = "*";
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        header("Access-Control-Allow-Origin: $origin", true);
        header("Access-Control-Allow-Headers: Origin,Content-Type,Authorization,x-access-token,application,uuid,version,platform");
        $this->enableCsrfValidation = false;
        return true;
    }
    public function actionIndex()
    {
        $users = User::find()->orderBy(['id'=>SORT_DESC])->all();
        $outptu = [];

        foreach ($users as $k=>$user){
            unset($user->password_hash);
            //unset($user->auth_key);
            $orders = ClsOrder::getOrder($user->id);

            $avatar_base_url = isset($user->profile->avatar_base_url)?$user->profile->avatar_base_url:'';
            $avatar_path = isset($user->profile->avatar_path)?$user->profile->avatar_path:'';
            $user->profile->avatar_path = "{$avatar_base_url}/{$avatar_path}";
            $outptu[]=[
              'count'=>count($users),
              'user'=>$user,
              'profile'=>$user->profile,
              'order'=>$orders
            ];
        }
        return CNMessage::getSuccess("success", $outptu);
    }
    public function actionGetMemberById()
    {
        $id = \Yii::$app->request->get('id');
        $user = User::find()->where('id=:id',[':id' => $id])->one();
        if($user){
            unset($user->password_hash);
            unset($user->auth_key);
            $orders = ClsOrder::getOrder($user->id);
            $avatar_base_url = isset($user->profile->avatar_base_url)?$user->profile->avatar_base_url:'';
            $avatar_path = isset($user->profile->avatar_path)?$user->profile->avatar_path:'';
            $user->profile->avatar_path = "{$avatar_base_url}/{$avatar_path}";
            $outptu=[
                'user'=>$user,
                'profile'=>$user->profile,
                'order'=>$orders
            ];

            return CNMessage::getSuccess("Success", $outptu);
        }else{
            return CNMessage::getError("Error","ไม่พบข้อมูล Founder");
        }
    }
    public function actionGetOrder()
    {
        try{
            $user_id = \Yii::$app->request->get('user_id');
            $outptu = [];
            $orders = ClsOrder::getOrder($user_id);
            $outptu[]=[
                'order'=>$orders
            ];
            return CNMessage::getSuccess("Success", $outptu);
        }catch (Exception $ex){
            return CNMessage::getSuccess("ไม่พบข้อมูล");
        }
    }
    public function actionGetOrderDetail()
    {
        try{
            $order_id = \Yii::$app->request->get('order_id');

            $orders = ClsOrder::getOrderDetail($order_id);
            if($orders){
                return CNMessage::getSuccess("Success", $orders);
            }else{
                return CNMessage::getSuccess("Success", []);
            }
        }catch (Exception $ex){
            return CNMessage::getSuccess("ไม่พบข้อมูล");
        }
    }
    public function actionUploadOrder()
    {
        try{
            $file = UploadedFile::getInstancesByName("file");

            return CNMessage::getSuccess("Success", "OK");
        }catch (Exception $ex){
            return CNMessage::getSuccess("ไม่พบข้อมูล");
        }
    }

}
