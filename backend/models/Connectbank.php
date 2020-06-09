<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "connectbank".
 *
 * @property int $id
 * @property int $user_id ผู้ใช้
 * @property string $name ชื่อบัญชี
 * @property string $account เลขที่บัญชี
 * @property string $detail รายละเอียด
 * @property int $bank ชื่อธนาคาร
 *
 * @property Bankitem $bank0
 */
class Connectbank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'connectbank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'bank','account'], 'required'],
            [['user_id', 'bank'], 'integer'],
            [['detail'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['account'], 'string', 'max' => 50],
            [['bank'], 'exist', 'skipOnError' => true, 'targetClass' => Bankitem::className(), 'targetAttribute' => ['bank' => 'id']],
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
            'name' => 'ชื่อบัญชี',
            'account' => 'เลขที่บัญชี',
            'detail' => 'รายละเอียด',
            'bank' => 'ชื่อธนาคาร',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanks()
    {
        return $this->hasOne(Bankitem::className(), ['id' => 'bank']);
    }
}
