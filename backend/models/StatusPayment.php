<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "statusPayment".
 *
 * @property int $id
 * @property string $status Status
 * @property int $user_id User ID
 * @property string $createDate Create Date
 * @property string $expireDate Expire Date
 * @property int $approveBy Approve By
 */
class StatusPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statusPayment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'approveBy'], 'integer'],
            [['createDate', 'expireDate'], 'safe'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'user_id' => 'User ID',
            'createDate' => 'Create Date',
            'expireDate' => 'Expire Date',
            'approveBy' => 'Approve By',
        ];
    }
}
