<?php

namespace backend\modules\games\models;

use Yii;

/**
 * This is the model class for table "game_score1".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $n1
 * @property string $n2
 * @property string $n3
 * @property string $n4
 * @property string $n5
 * @property string $n6
 * @property string $n7
 * @property string $n8
 * @property int $score
 * @property string $createBy
 * @property string $createDate
 */
class GameScore1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_score1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'score'], 'integer'],
            [['createDate'], 'safe'],
            [['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'n7', 'n8'], 'string', 'max' => 10],
            [['createBy'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'n1' => 'N1',
            'n2' => 'N2',
            'n3' => 'N3',
            'n4' => 'N4',
            'n5' => 'N5',
            'n6' => 'N6',
            'n7' => 'N7',
            'n8' => 'N8',
            'score' => 'Score',
            'createBy' => 'Create By',
            'createDate' => 'Create Date',
        ];
    }
}
