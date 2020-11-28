<?php
namespace common\modules\user\controllers;
use appxq\sdii\utils\VarDumper;
use common\modules\user\classes\CNUserFunc;
use common\modules\user\models\User;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use common\modules\user\models\LoginForm;
use yii\db\Query;

class SecurityController extends BaseSecurityController{
    //put your code here
    public function actionLogin()
    {
        $this->layout = '@backend/themes/admin/layouts/login.php';
        \Yii::$app->language='th-TH';
//       $redirectUrl = \Yii::$app->request->get('redirectUrl');
//       if(empty( \Yii::$app->session['redirectUrl'])){
//           \Yii::$app->session['redirectUrl']=$redirectUrl;
//       }

       // $this->layout='@backend/themes/adminlte/views/layouts/main';
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $url = isset(\Yii::$app->session['redirectUrl'])?\Yii::$app->session['redirectUrl']:'';

        if (\Yii::$app->getRequest()->post()) {

            $post = \Yii::$app->request->post('login-form');
            $username = $post['login'];
            $password = $post['password'];
            $user = (new Query())
                ->select('user.*,profile.*')
                ->from('user')
                ->innerJoin('profile','user.id=profile.user_id')
                ->where('profile.tel=:tel')
                ->addParams([':tel'=>$username])->one();

            if($user){
//                VarDumper::dump($user);
                $validatePassword = \Yii::$app->getSecurity()->validatePassword($password, $user['password_hash']);
                if($validatePassword){
//                    VarDumper::dump($user);
                    if($url != ''){
                        // VarDumper::dump($url);
                        $baseUrl = $url.'/login';
                        $url = "{$baseUrl}?token={$user['auth_key']}";
                        \Yii::$app->user->logout();
                        return $this->redirect($url);
                    }else{
                        return $this->goHome();
                    }
                }
            }
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);
        //VarDumper::dump($model);exit();
        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            $user = User::find()->where('id=:id',[':id'=>CNUserFunc::getUserId()])->one();

            //$url = isset(\Yii::$app->session['redirectUrl'])?\Yii::$app->session['redirectUrl']:'';
            if($url != ''){
               // VarDumper::dump($url);
                $baseUrl = $url.'/login';
                $url = "{$baseUrl}?token={$user['auth_key']}";
                \Yii::$app->user->logout();
                return $this->redirect($url);
            }else{
                if(\Yii::$app->user->can('admin')) {
                    return $this->redirect(['/admins']);
                }
                return $this->goHome();
            }
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}
