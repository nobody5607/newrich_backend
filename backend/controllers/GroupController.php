<?php


namespace backend\controllers;


use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\VarDumper;
use backend\models\CreateBusines;
use backend\models\search\Informations as InformationsSearch;
use common\modules\user\models\User;
use yii\web\Controller;

class GroupController extends Controller
{
    public function actionIndex($token)
    {
        $user = $this->getUser($token);
        if(!$user){
            throw new \yii\web\HttpException(403, 'คุณไม่มีสิทธิ์เข้าใช้งานส่วนนี้');
        }
//        $checkPassword = $this->validatePassword('123456s',$token);
        return $this->render('index', ['token'=>$token]);
    }

    public function actionBusines($groupID)
    {
        return $this->render('busines',[
            'groupID'=>$groupID
        ]);
    }
    public function createDefaultBusines($groupID){
//        VarDumper::dump($groupID);
        for($i=1; $i<=3; $i++){
            $model = new CreateBusines();
            $model->groupID = $groupID;
            if($i==1){
                $model->title = "ลงทนในธุรกิจ";
                $model->orderBy = 1;
            }else if($i==2){
                $model->title = "สงเสริมการลงทุน";
                $model->orderBy = 2;
            }else{
                $model->title = "เรียนรู้ผ่าน ZOOM";
                $model->orderBy = 3;
            }

            $model->createBy = isset(\Yii::$app->session['user_id'])?\Yii::$app->session['user_id']:'';;
            $model->createDate = date('Y-m-d H:i:s');
            $model->save();
        }
        return true;
    }
    public function getBusines($groupID){
        $model = CreateBusines::find()->where('groupID=:groupID',[
            ':groupID'=>$groupID
        ])->all();
        return $model;
    }
    public function actionGetBusines()
    {
        $groupID = \Yii::$app->request->get('groupID');
//        VarDumper::dump($groupID);
        $model = $this->getBusines($groupID);
        if(!$model && $this->createDefaultBusines($groupID)){
            $model = $this->getBusines($groupID);
        }

        //VarDumper::dump($model);
        return $this->renderAjax('_get-busines', [
            'groupID'=>$groupID,
            'model'=>$model
        ]);
    }

    public function getUser($token){
        $user = User::find()->where('auth_key=:token',[':token'=>$token])->one();
        return $user;
    }
    public function validatePassword($password, $token) {
        $user = $this->getUser($token);
//        return $password;
        return \Yii::$app->security->validatePassword ( $password, $user->password_hash );

    }

    public function actionUpdate(){
//        actionUpdate$user = User::find()->where('auth_key=:token',[':token'=>$token])->one();
//        return $user;$user
    }
}