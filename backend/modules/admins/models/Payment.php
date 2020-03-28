<?php

namespace backend\modules\admins\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $user_id ผู้ใช้
 * @property int $status สถานะชำระเงิน
 * @property string $stdate วันที่เริ่มต้นใช้งาน
 * @property int $amount จำนวนวัน
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างวันที่
 * @property int $rstat สถานะ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขวันที่
 *
 * @property User $user
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'stdate','endate','token'], 'required'],
            [['user_id', 'status', 'create_by', 'rstat', 'update_by'], 'integer'],
            [['create_date', 'update_date','amount'], 'safe'],
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
            'user_id' => 'ผู้ใช้',
            'status' => 'สถานะชำระเงิน',
            'stdate' => 'วันที่เริ่มต้นใช้งาน',
            'endate'=>'วันที่หมดอายุการใช้งาน',
            'amount' => 'จำนวนวัน',
            'create_by' => 'สร้างโดย',
            'create_date' => 'สร้างวันที่',
            'rstat' => 'สถานะ',
            'update_by' => 'แก้ไขโดย',
            'update_date' => 'แก้ไขวันที่',
            'token'=>'คีย์'
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
