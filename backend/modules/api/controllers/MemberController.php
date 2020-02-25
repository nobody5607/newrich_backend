<?php

namespace backend\modules\api\controllers;

use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\VarDumper;
use backend\modules\api\classes\ClsAccessCoss;
use backend\modules\api\classes\ClsAuth;
use backend\modules\api\classes\ClsOrder;
use common\modules\user\models\Profile;
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
    private $token = "";
    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin,Content-Type,Authorization,x-access-token,application,uuid,version,platform");
        $this->enableCsrfValidation = false;
        $this->token = \Yii::$app->request->headers->get('x-access-token');
        if(!$this->token){
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        return true;
    }
    public function actionGetMember(){
        $limit = \Yii::$app->request->get('limit');
        $site = \Yii::$app->request->get('site');

        $user = ClsAuth::getUserByToken($this->token);
        $output = [];
        if($user){
            $profile = Profile::find()
                ->where('parent_id=:parent_id AND user_id <> :user_id',[
                ':parent_id' => $user->id,
                ':user_id' => $user->id
            ])->limit($limit)->all();
            $storageUrl = isset(\Yii::$app->params['storageUrl'])?\Yii::$app->params['storageUrl']:'';
            foreach($profile as $k=>$v){
                $avatar_path = isset($v->avatar_path)?$v->avatar_path:'';
                if($avatar_path != ''){
                    $v->avatar_path = "{$storageUrl}/uploads/{$avatar_path}";
                }
                $v->create_date = isset($v->create_date)?SDdate::mysql2phpThDateSmall($v->create_date):'';
                $output[] = [
                    'user_id'=>$v['user_id'],
                    'name'=>$v['name'],
                    'avatar_path'=>$v['avatar_path'],
                    'member_type'=>$v['member_type'],
                    'link'=>$v['link'],
                    'create_date'=>$v['create_date']
                ];
            }
            return CNMessage::getSuccess("success", $output);
        }

    }
    public function actionIndex()
    {

        $limit = \Yii::$app->request->get('limit');
        $query = User::find()->orderBy(['id'=>SORT_DESC]);
        $users = $query->all();
        if($limit){
            $users = $query->limit($limit)->all();
        }else{
            $users = $query->all();
        }

        $outptu = [];

        foreach ($users as $k=>$user){
            unset($user->password_hash);
            //unset($user->auth_key);
            $orders = ClsOrder::getOrder($user->id);
            $avatar_base_url = isset($user->profile->avatar_base_url)?$user->profile->avatar_base_url:'';
            $avatar_path = isset($user->profile->avatar_path)?$user->profile->avatar_path:'';
            $storageUrl = isset(\Yii::$app->params['storageUrl'])?\Yii::$app->params['storageUrl']:'';
            $user->profile->avatar_path = "{$storageUrl}/uploads/{$avatar_path}";
            $user->profile->create_date = isset($user->profile->create_date)?SDdate::mysql2phpThDateSmall($user->profile->create_date):'';
            //return $user->profile->image;
            $outptu[]=[
              'count'=>count($users),
              'user'=>$user,
              'profile'=>$user->profile,
              'order'=>$orders
            ];
        }
        return CNMessage::getSuccess("success", $outptu);
    }


    public function actionGetMemberByType(){
        $type= \Yii::$app->request->get('type');
        $output = [];
        $profiles = Profile::find()->where('member_type=:type',[':type'=>$type])->all();
        if(!$profiles){
            return CNMessage::getError("Success","ไม่พบข้อมูล");
        }
        $storageUrl = isset(\Yii::$app->params['storageUrl'])?\Yii::$app->params['storageUrl']:'';
        foreach($profiles as $k=>$profile){
            $id = $profile->user_id;
            $user = User::find()->where('id=:id',[':id' => $id])->one();
            $avatar_path = isset($profile->avatar_path)?$profile->avatar_path:'';
            $profile->avatar_path = "{$storageUrl}/uploads/{$avatar_path}";
            $output[] = [
                'user_id'=>$profile['user_id'],
                'name'=>$profile['name'],
                'avatar_path'=>$profile['avatar_path'],
                'member_type'=>$profile['member_type'],
                'link'=>$profile['link'],
                'create_date'=>$profile['create_date']
            ];
//            $output[] = [
//                'user'=>$user,
//                'profile'=>$profile,
//                'order'=>[]
//            ];
        }
        return CNMessage::getSuccess("Success", $output);
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
           // $user->profile->avatar_path = "{$avatar_base_url}/{$avatar_path}";
            $storageUrl = isset(\Yii::$app->params['storageUrl'])?\Yii::$app->params['storageUrl']:'';
            $avatar_path = isset($user->profile->avatar_path)?$user->profile->avatar_path:'';
            if($avatar_path != ''){
                $user->profile->avatar_path = "{$storageUrl}/uploads/{$avatar_path}";
            }

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
