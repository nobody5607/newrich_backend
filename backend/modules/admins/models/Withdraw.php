<?php

namespace backend\modules\admins\models;

use appxq\sdii\utils\VarDumper;
use Yii;
use yii\web\UploadedFile;

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
            [['createDate', 'approveDate','rstat','create_by','create_date','update_by','update_date','status','image'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['image'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',]
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
            'status' => 'สถานะการโอนเงิน',
            'approveBy'=>'อนุมัติโดย',
            'image'=>'หลักฐานการโอน'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function upload()
    {
        $storage = \Yii::getAlias('@storage');
        if ($this->validate()) {
            $extensions = explode('.',$this->image->name);

            $newFile = 'approve_money_'.date('YmdHis').rand(00,999);
            $extensions = end($extensions);
            $fileName="{$newFile}.{$extensions}";
            $this->image->saveAs("{$storage}/web/images/approved/" .$fileName);
            $this->image = $fileName;
//
            return true;
        } else {
            return false;
        }
    }
}
