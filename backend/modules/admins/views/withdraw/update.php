<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Withdraw */

$this->title = 'Update Withdraw: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ถอนเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = \backend\lib\CNUtils::getUserById($model->user_id);
?>
<div class="withdraw-update">
    <?php
    $bankUser = \backend\models\Connectbank::find()->where(['user_id' => $model->user_id, 'active' => 1])->one();

    ?>
    <?php if ($bankUser) { ?>
        <?php
        $bank = \backend\models\Bankitem::findOne($bankUser->bank);
        ?>
        <div class="card mb-3">
            <div class="card-header">ข้อมูลธนาคาร</div>
            <div _ngcontent-serverapp-c134="" class="card-body">
                <table _ngcontent-serverapp-c134="">
                    <tr _ngcontent-serverapp-c134="">
                        <td _ngcontent-serverapp-c134="" class="text-right">ชื่อธนาคาร : </td>
                        <td _ngcontent-serverapp-c134=""><b _ngcontent-serverapp-c134=""><?= $bank->name; ?></b></td>
                    </tr>
                    <tr _ngcontent-serverapp-c134="">
                        <td _ngcontent-serverapp-c134="" class="text-right">เลขที่บัญชี : </td>
                        <td _ngcontent-serverapp-c134=""><b _ngcontent-serverapp-c134=""><?= $bankUser->account; ?></b></td>
                    </tr>
                    <tr _ngcontent-serverapp-c134="">
                        <td _ngcontent-serverapp-c134="" class="text-right">ชื่อบัญชี : </td>
                        <td _ngcontent-serverapp-c134="">
                            <div _ngcontent-serverapp-c134=""><b _ngcontent-serverapp-c134=""><?= $bankUser->name; ?></b></div>
                            <div _ngcontent-serverapp-c134=""><b _ngcontent-serverapp-c134=""></b></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
