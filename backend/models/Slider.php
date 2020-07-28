<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id รหัส
 * @property int|null $order ลำดับที่
 * @property string|null $getAt วันที่สร้าง
 * @property string|null $image รูปภาพ
 * @property int|null $rstat สถานะ
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
//            [['image'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png,jpg,jpeg'],
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
        ];
    }

    public function upload()
    {
        $storage = \Yii::getAlias('@storage');
        if ($this->validate()) {
            $newFile = 'brief'.date('YmdHis').rand(00,999);
            $extensions = $this->image->extension;
            $fileName="{$newFile}.{$extensions}";
            $this->image->saveAs("{$storage}/web/images/" .$fileName);
            $this->image = $fileName;
            return true;
        } else {
            return false;
        }
    }
}
