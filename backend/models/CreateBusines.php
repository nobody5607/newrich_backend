<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "createBusines".
 *
 * @property int $id
 * @property string $title
 * @property string $detail
 * @property int $createBy
 * @property string $createDate
 * @property int $orderBy
 */
class CreateBusines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'createBusines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createBy', 'orderBy'], 'integer'],
            [['createDate','groupID'], 'safe'],
            [['title', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'หัวข้อ',
            'detail' => 'รายละเอียด',
            'createBy' => 'Create By',
            'createDate' => 'Create Date',
            'orderBy' => 'Order By',
            'groupID'=>'groupID'
        ];
    }
}
