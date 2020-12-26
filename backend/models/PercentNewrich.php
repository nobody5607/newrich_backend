<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "percent_newrich".
 *
 * @property int $id
 * @property string $totalPrice ยอดซื้อรวม
 * @property string $parentNewriched ส่วนแบ่งเข้าระบบ
 * @property string $customerPercent ลูกค้า %
 * @property string $parentPercent ผู้แนะนำ %
 * @property string $percentPercent นิวริช
 * @property int $create_by
 * @property string $create_date
 * @property int $update_by
 * @property string $update_date
 */
class PercentNewrich extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'percent_newrich';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['totalPrice', 'parentNewriched', 'customerPercent', 'parentPercent', 'percentPercent'], 'number'],
            [['create_by', 'update_by'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'totalPrice' => 'ยอดซื้อรวม',
            'parentNewriched' => 'ส่วนแบ่งเข้าระบบ',
            'customerPercent' => 'ลูกค้า %',
            'parentPercent' => 'ผู้แนะนำ %',
            'percentPercent' => 'นิวริช',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
