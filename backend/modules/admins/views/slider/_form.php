<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin([
        'id'=>'formSubmit',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'image')->fileInput() ?>
    <?= $form->field($model, 'order')->textInput(['type'=>'number']) ?>
    <div class="form-group text-right">
        <?= Html::submitButton('ยืนยัน', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
