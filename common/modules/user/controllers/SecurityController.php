<?php
namespace common\modules\user\controllers;
use appxq\sdii\utils\VarDumper;
use common\modules\user\classes\CNUserFunc;
use common\modules\user\models\User;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use common\modules\user\models\LoginForm; 
class SecurityController extends BaseSecurityController{
    //put your code here
    public function actionLogin()
    {
       
       // $this->layout='@backend/themes/adminlte/views/layouts/main';
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
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
            $baseUrl = 'http://newriched.com/login';
            $url = "{$baseUrl}?token={$user['auth_key']}";
            Yii::$app->user->logout();
            return $this->redirect($url);


            //return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}
