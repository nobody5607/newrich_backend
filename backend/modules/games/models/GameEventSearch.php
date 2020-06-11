<?php

namespace backend\modules\games\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\games\models\GameEvent;

/**
 * GameEventSearch represents the model behind the search form of `backend\modules\games\models\GameEvent`.
 */
class GameEventSearch extends GameEvent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'number'], 'integer'],
            [['title', 'answer', 'qu1', 'qu2', 'createDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GameEvent::find()->where(['parent_id'=>$params['parent_id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'number' => $this->number,
            'createDate' => $this->createDate,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'qu1', $this->qu1])
            ->andFilterWhere(['like', 'qu2', $this->qu2]);

        return $dataProvider;
    }
}
