<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bankitem".
 *
 * @property int $id
 * @property string $name
 *
 * @property Connectbank[] $connectbanks
 */
class Bankitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bankitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConnectbanks()
    {
        return $this->hasMany(Connectbank::className(), ['bank' => 'id']);
    }
}
