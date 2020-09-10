<?php

namespace backend\modules\games\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int $create_by
 * @property string $create_date
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id', 'create_by'], 'integer'],
            [['create_date','status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
        ];
    }
}
