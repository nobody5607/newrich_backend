<?php

namespace backend\modules\games\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $room_id
 * @property string $msg
 * @property string $file
 * @property int $create_by
 * @property string $create_date
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'create_by'], 'integer'],
            [['msg'], 'string'],
            [['create_date'], 'safe'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'msg' => 'Msg',
            'file' => 'File',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
        ];
    }
}
