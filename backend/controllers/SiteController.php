<?php
namespace backend\controllers;

use appxq\sdii\utils\VarDumper;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use kartik\mpdf\Pdf;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }


    public function oAuthSuccess($client) {
        // get user data from client
        $userAttributes = $client->getUserAttributes();

        VarDumper::dump($userAttributes);
        if(empty($userAttributes['email'])){
            Yii::$app->session->setFlash('error', 'กรุณากด Allow Access ใน Facebook เพื่อใช้งาน Facebook Login');
            return $this->redirect('/site/login');
        }
        $user = User::findOne(['email' => $userAttributes['email']]);

        if($user){//ถ้ามี user ในระบบแล้ว
            //echo 'user email';
            if($user->status != User::STATUS_ACTIVE){//ถ้าสถานะไม่ active ให้ active
                $user->status = User::STATUS_ACTIVE;
                $user->save();
            }
            $profile = Profile::find()->where(['user_id' => $user->id])->one();
            if(!$profile){// ถ้าไม่มี profile ให้สร้างใหม่
                $name = explode(" ", $userAttributes['name']);// แยกชื่อ นามสกุล

                $pf = new Profile();
                $pf->firstname = $name[0];
                $pf->lastname = $name[1];
                $pf->save();
            }

            Yii::$app->getUser()->login($user);
        }else{//ถ้าไม่มี user ในระบบ
            //echo 'none user';
            //$generate = Yii::$app->security->generateRandomString(10);
            $uname = explode("@", $userAttributes['email']);// แยกอีเมลล์ด้วย @
            $getuser = User::findOne(['username' => $uname[0]]);
            if($getuser){//มี username จาก username ที่ได้จาก email
                //echo 'exit user from username';
                $rand = rand(10, 99);
                $username = $uname[0].$rand;
            }else{
                //echo 'none user from username';
                $username = $uname[0];
            }
            //echo $username;
            $new_user = new User();
            $new_user->username = $username;
            $new_user->auth_key = Yii::$app->security->generateRandomString();
            $new_user->password_hash = Yii::$app->security->generatePasswordHash($username);
            $new_user->email = $userAttributes['email'];
            $new_user->status = User::STATUS_ACTIVE;

            if($new_user->save()){
                //echo 'save user';
                $name = explode(" ", $userAttributes['name']);// แยกชื่อ นามสกุล
                $new_profile = new Profile();
                $new_profile->user_id = $new_user->id;
                $new_profile->firstname = $name[0];
                $new_profile->lastname = $name[1];
                $new_profile->save();
                Yii::$app->getUser()->login($new_user);

            }else{
                //echo 'not save user';
            }

        }
        //exit();
        // do some thing with user data. for example with $userAttributes['email']
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
         return $this->render('index');
 
    }
    public function actionAbout()
    {
        return $this->render('about');
 
    }
    public function actionContact()
    {
        return $this->render('contact');
 
    }
    
    public function actionEdit()
    {
       $params = \Yii::$app->request->get('params', '');
       $model = \common\models\Options::find()->where('label=:label',[
           ':label'=>$params
       ])->one();
       if($model->load(Yii::$app->request->post()) && $model->save()){
           return \cpn\chanpan\classes\CNMessage::getSuccess('Success');
       }
       return $this->renderAjax('edit',[
           'model'=>$model,
           'params'=>$params
       ]);
 
    }
    public function actionSocial()
    {
        return $this->renderPartial('social');

    }
 
}
