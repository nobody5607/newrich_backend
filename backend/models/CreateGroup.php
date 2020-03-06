<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "createGroup".
 *
 * @property int $id
 * @property string $name
 * @property int $createBy
 * @property string $createDate
 * @property int $orderBy
 */
class CreateGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'createGroup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createBy', 'orderBy'], 'integer'],
            [['createDate'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'required','message'=>'ชื่อกลุ่มต้องไม่ว่างเปล่า'],
            [['password'], 'required','message'=>'รหัสผ่านต้องไม่ว่างเปล่า'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'รหัสผ่านสำหรับเข้าใช้งาน',
            'name' => 'ชื่อกลุ่ม',
            'createBy' => 'สร้างโดย',
            'createDate' => 'สร้างเมื่อ',
            'orderBy' => 'เรียงลำดับ',
        ];
    }
}
