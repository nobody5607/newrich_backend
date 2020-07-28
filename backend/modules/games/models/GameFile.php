<?php

namespace backend\modules\games\models;

use Yii;

/**
 * This is the model class for table "game_file".
 *
 * @property int $id
 * @property string $filename
 * @property int $createBy
 * @property string $createDate
 * @property string $msg
 */
class GameFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createBy'], 'integer'],
            [['createDate','uuid'], 'safe'],
            [['msg'], 'string'],
            [['filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'createBy' => 'Create By',
            'createDate' => 'Create Date',
            'msg' => 'Msg',
        ];
    }
}
