<?php


namespace backend\models;


use yii\base\Model;

class Files extends Model
{
    public $file;
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'ไฟล์'
        ];
    }
}