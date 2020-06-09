<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id รหัส
 * @property int $order ลำดับที่
 * @property string $getAt วันที่สร้าง
 * @property string $image รูปภาพ
 * @property int $rstat สถานะ
 * @property string $department
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order', 'rstat'], 'integer'],
            [['getAt'], 'safe'],
            [['image', 'department'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'order' => 'ลำดับที่',
            'getAt' => 'วันที่สร้าง',
            'image' => 'รูปภาพ',
            'rstat' => 'สถานะ',
            'department' => 'Department',
        ];
    }
}
