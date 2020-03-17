<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $id รหัสการสั่งซื้อ
 * @property int $user_id รหัส founder
 * @property string $order ยอดสั่งซื้อ
 * @property string $score คะแนนรวม
 * @property string $percent Percent รวม
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property int $rstat สถานะ
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['create_by', 'update_by', 'rstat'], 'integer'],
            [['create_date', 'update_date','user_id'], 'safe'],
            [['id'], 'string', 'max' => 100],
            [['order', 'score', 'percent'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสการสั่งซื้อ',
            'user_id' => 'รหัส founder',
            'order' => 'ยอดสั่งซื้อ',
            'score' => 'คะแนนรวม',
            'percent' => 'Percent รวม',
            'create_by' => 'สร้างโดย',
            'create_date' => 'สร้างเมื่อ',
            'update_by' => 'แก้ไขโดย',
            'update_date' => 'แก้ไขเมื่อ',
            'rstat' => 'สถานะ',
        ];
    }
}
