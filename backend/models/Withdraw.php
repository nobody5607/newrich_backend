<?php

namespace backend\models;

use backend\modules\admins\models\User;
use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property int $id
 * @property int $user_id รหัสผู้ใช้
 * @property int $amount จำนวนเงิน
 * @property string $createDate วันที่ถอน
 * @property int $approveBy อนุมัติโดย
 * @property string $approveDate อนุมัติวันที่
 *
 * @property User $user
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'approveBy'], 'integer'],
            [['createDate', 'approveDate'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'รหัสผู้ใช้',
            'amount' => 'จำนวนเงิน',
            'createDate' => 'วันที่ถอน',
            'approveBy' => 'อนุมัติโดย',
            'approveDate' => 'อนุมัติวันที่',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
