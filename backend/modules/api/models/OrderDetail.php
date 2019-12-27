<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id
 * @property string $order_id รหัสการสั่งซื้อ
 * @property string $product_id รหัสสินค้า
 * @property string $product_name ชื่อสินค้า
 * @property int $qty จำนวน
 * @property string $price ราคา
 * @property int $score คะแนน
 * @property string $percent Percent/บาท
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property string $unit_price ราคาต่อหน่วย
 * @property int $rstat สถานะ
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qty', 'score', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['order_id', 'product_id'], 'string', 'max' => 100],
            [['product_name', 'percent', 'unit_price'], 'string', 'max' => 255],
            [['price'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'รหัสการสั่งซื้อ',
            'product_id' => 'รหัสสินค้า',
            'product_name' => 'ชื่อสินค้า',
            'qty' => 'จำนวน',
            'price' => 'ราคา',
            'score' => 'คะแนน',
            'percent' => 'Percent/บาท',
            'create_by' => 'สร้างโดย',
            'create_date' => 'สร้างเมื่อ',
            'update_by' => 'แก้ไขโดย',
            'update_date' => 'แก้ไขเมื่อ',
            'unit_price' => 'ราคาต่อหน่วย',
            'rstat' => 'สถานะ',
        ];
    }
}
