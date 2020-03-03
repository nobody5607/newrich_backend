<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

//use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback','autofocus' => 'autofocus',  'tabindex' => '1'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback','tabindex' => '2'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
//https://backend.newriched.com/site/auth?authclient=facebook
?>

<div class="row">

    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-body">
                <?=
                common\modules\user\classes\CNAuthChoice::widget([
                    'baseAuthUrl' => ['/site/auth'],
                    'popupMode' => false,
                    'options' => [
                    ]
                ])
                ?>


                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

                <?php if ($module->debug): ?>
                    <?= $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>

                <?php else: ?>

                    <?= $form->field($model, 'login',$fieldOptions1);
                    ?>

                <?php endif ?>

                <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
                    <?= $form->field(
                        $model,
                        'password',
                        $fieldOptions2)
                        ->passwordInput()
                        ->label(
                            Yii::t('user', 'Password')
                            . ($module->enablePasswordRecovery ?
                                ' (' . Html::a(
                                    Yii::t('user', 'Forgot password?'),
                                    ['/user/recovery/request'],
                                    ['tabindex' => '5']
                                )
                                . ')' : '')
                        ) ?>
                <?php endif ?>
                 <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
                 <?= Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block btn-lg', 'tabindex' => '4']
                ) ?>

                <?php ActiveForm::end(); ?>
                <!-- /.social-auth-links -->
                <div  style="margin-top:10px;">
                    <?php if ($module->enableConfirmation): ?>
                        <p class="text-center">
                            <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                        </p>
                    <?php endif ?>
                    <?php if ($module->enableRegistration): ?>
                        <p class="text-center">
                            <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), 'https://newriched.com/register') ?>
                        </p>
                    <?php endif ?>
                </div>
                
            </div>
            
            
        </div>
        
    </div>
     
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    .form-control {
        display: block;
        width: 100%;
        height: 45px;
        padding: 6px 12px;
        font-size: 20px;
        line-height: 1.428571;
        color: #555555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end()?>


 