<?php

namespace backend\modules\admins\models;

use Yii;

/**
 * This is the model class for table "refund".
 *
 * @property int $id
 * @property int $user_id ผู้ใช้
 * @property string $order_id เลขที่ใบสั่งซื้อ
 * @property string $amount จำนวนเงิน
 * @property int $approveBy ยืนยันโดย
 * @property string $approveDate ยืนยันเมื่อ
 * @property int $rstat
 * @property int $create_by
 * @property string $create_date
 * @property int $update_by
 * @property string $update_datte
 */
class Refund extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refund';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'approveBy', 'rstat', 'create_by', 'update_by'], 'integer'],
            [['amount'], 'number'],
            [['approveDate', 'create_date', 'update_datte','status','payment'], 'safe'],
            [['order_id'], 'string', 'max' => 100],
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
            'order_id' => 'เลขที่ใบสั่งซื้อ',
            'amount' => 'จำนวนเงิน',
            'approveBy' => 'ยืนยันโดย',
            'approveDate' => 'ยืนยันเมื่อ',
            'rstat' => 'Rstat',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'status' => 'สถานะการอนุมัติ',
            'payment'=>'สถานะการโอน'
        ];
    }
}
