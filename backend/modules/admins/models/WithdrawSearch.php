<?php

namespace backend\modules\admins\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admins\models\Withdraw;

/**
 * WithdrawSearch represents the model behind the search form about `backend\modules\admins\models\Withdraw`.
 */
class WithdrawSearch extends Withdraw
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'amount', 'approveBy','status'], 'integer'],
            [['createDate', 'approveDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Withdraw::find()->where('rstat not in(0,3)');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'createDate' => $this->createDate,
            'approveBy' => $this->approveBy,
            'approveDate' => $this->approveDate,
        ]);

        return $dataProvider;
    }
}
