<?php
namespace backend\controllers;

use appxq\sdii\utils\VarDumper;
use common\modules\user\classes\CNUserFunc;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],

        ];
    }
    public function onAuthSuccess($client)
    {
        $userAttributes = $client->getUserAttributes();
        $baseUrl = 'http://newriched.com/login';

        //VarDumper::dump($userAttributes);
        if(!$userAttributes['email']){
            return "Notfound Email!";
        }

        $user = User::getUserByEmail($userAttributes['email']);
        if($user){
            $url = "{$baseUrl}?token={$user['auth_key']}";
            return $this->redirect($url);
//            return \Yii::$app->user->login($user);
        }else{
            $user = new User();
           // $user->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $user->username = date('YmdHis'). rand(0,10000).time();
            $user->password = Yii::$app->security->generateRandomString(12);
            $user->email = isset($userAttributes['email']) ? $userAttributes['email'] : '';
            $user->created_at = time();
            $user->confirmed_at = time();
            $user->updated_at =time();
            $user->flags = 0;
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            if($user->save()){
                try{
                    $assignData = ['item_name'=>'user','user_id'=>$user->id, 'created_at'=> time()];
                    \Yii::$app->db->createCommand()->insert('auth_assignment', $assignData)->execute();
                } catch (\yii\db\Exception $ex){
                }
                $profile = Profile::findOne($user->id);
                $profile->user_id = $user->id;
                $profile->name = isset($userAttributes['name']) ? $userAttributes['name'] : '';
                $profile->public_email = isset($userAttributes['email']) ? $userAttributes['email'] : '';
                $profile->gravatar_email = isset($userAttributes['email']) ? $userAttributes['email'] : '';
                $profile->lastname = $userAttributes['last_name'];
                $profile->firstname = $userAttributes['first_name'];
                $profile->sitecode = '0001'; //$this->sitecode,
                $profile->site = '0001'; //$this->sitecode,
                $profile->link = 'Newrich'.Date('dmYHis').time().rand(1000000,999999999);
                if($profile->save()){
                    $user = User::getUserByEmail($userAttributes['email']);
                    $url = "{$baseUrl}?token={$user['auth_key']}";
                    return $this->redirect($url);
                    //return \Yii::$app->user->login($user);
                }

            }

        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        //return $this->render('index');
//        Yii::$app->mailer->compose('@backend/mail/layouts/reset',[
//            'fullname'=>'สาธิต สีถาพล'
//        ])
//            ->setFrom(['chanpan.nuttaphon@gmail.com'=>'Nuttaphon Chanpan'])
//            ->setTo('chanpan.nuttaphon1993@gmail.com')
//            ->setSubject('OK')
//            ->send();send


        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/login']);
        }
        \Yii::$app->user->logout();
        $url = isset(\Yii::$app->session['redirectUrl'])?\Yii::$app->session['redirectUrl']:'';
        if($url != ''){
            $user = User::find()->where('id=:id',[':id'=>CNUserFunc::getUserId()])->one();
            //$baseUrl = 'http://newriched.com/login';
            $url = "{$url}?token={$user['auth_key']}";
            \Yii::$app->user->logout();
            return $this->redirect($url);
        }
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
