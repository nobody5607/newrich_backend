<?php

namespace backend\modules\games\models;

use Yii;

/**
 * This is the model class for table "game_event".
 *
 * @property int $id
 * @property int $parent_id หัวข้อ
 * @property int $number
 * @property string $title
 * @property string $answer
 * @property string $qu1
 * @property string $qu2
 * @property string $createDate
 */
class GameEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'number'], 'integer'],
            [['createDate'], 'safe'],
            [['title', 'answer', 'qu1', 'qu2'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'หัวข้อใหญ่',
            'title' => 'คำถาม',
            'number' => 'ข้อทที่',
            'answer' => 'คำตอบ',
            'qu1' => 'ช้อย1',
            'qu2' => 'ช้อย2',
            'createDate' => 'วันที่เพิ่ม',
        ];
    }
}
