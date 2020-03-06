<?php

namespace backend\models\CreateGroup;

use Yii;

/**
 * This is the model class for table "createGroup".
 *
 * @property int $id
 * @property string $name
 * @property int $createBy
 * @property string $createDate
 * @property int $orderBy
 * @property string $password
 */
class CreateGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'createGroup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createBy', 'orderBy'], 'integer'],
            [['createDate'], 'safe'],
            [['name', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'createBy' => 'Create By',
            'createDate' => 'Create Date',
            'orderBy' => 'Order By',
            'password' => 'Password',
        ];
    }
}
