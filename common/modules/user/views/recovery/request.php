<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use appxq\sdii\helpers\SDHtml;
use appxq\sdii\helpers\SDNoty;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Recover your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Saved!</h4>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'password-recovery-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary btn-block']) ?><br>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php  \richardfan\widget\JSRegister::begin(); ?>
    <script>
        // JS script
        $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
            var $form = $(this);
            $.post(
                $form.attr('action'), //serialize Yii2 form
                $form.serialize()
            ).done(function(result) {
                if(result.status == 'success') {
                    <?= SDNoty::show('result.message', 'result.status')?>
                    if(result.action == 'create') {
                        //$(\$form).trigger('reset');
                        $(document).find('#modal-informations').modal('hide');
                        $.pjax.reload({container:'#informations-grid-pjax'});
                    } else if(result.action == 'update') {
                        $(document).find('#modal-informations').modal('hide');
                        $.pjax.reload({container:'#informations-grid-pjax'});
                    }
                } else {
                    <?= SDNoty::show('result.message', 'result.status')?>
                }
            }).fail(function() {
                <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                console.log('server error');
            });
            return false;
        });
    </script>
<?php  \richardfan\widget\JSRegister::end(); ?>