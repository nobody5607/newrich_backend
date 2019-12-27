<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class ProductController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDetail()
    {
        return $this->render('detail');
    }
    public function actionCustomStamp()
    {
        return $this->render('custom-stamp');
    }
    public function actionCustomStampWizards()
    {
        return $this->render('custom-stamp-wizards');
    }
    public function actionCustomStampMaker()
    {
        return $this->render('custom-stamp-maker');
    }
    public function actionDateStampWizard()
    {
        return $this->render('date-stamp-wizard');
    }
    public function actionBandStampWizard()
    {
        return $this->render('band-stamp-wizard');
    }



}
