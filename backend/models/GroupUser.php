<?php

namespace backend\models;

use common\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "groupUser".
 *
 * @property int $id
 * @property int $group_id กลุ่ม
 * @property int $user_id ผู้ใช้
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างวันที่
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขวันที่
 * @property int $rstat สถานะ
 *
 * @property CreateGroup $group
 * @property User $updateBy
 * @property User $createBy
 */
class GroupUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'groupUser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id'], 'required'],
            [['group_id', 'user_id', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => CreateGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['update_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_by' => 'id']],
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'กลุ่ม',
            'user_id' => 'ผู้ใช้',
            'create_by' => 'สร้างโดย',
            'create_date' => 'สร้างวันที่',
            'update_by' => 'แก้ไขโดย',
            'update_date' => 'แก้ไขวันที่',
            'rstat' => 'สถานะ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(CreateGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'update_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'create_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
