<?php

namespace backend\modules\admins\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\admins\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\modules\admins\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public $name, $member_type, $tel, $link;
    public function rules()
    {
        return [
            [['confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'flags', 'last_login_at'], 'integer'],
            [['name', 'member_type', 'email', 'tel', 'link', 'unconfirmed_email', 'registration_ip'], 'safe'],
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
        $query = User::find();
        $query->innerJoin('profile','profile.user_id=user.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'confirmed_at' => $this->confirmed_at,
            'blocked_at' => $this->blocked_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'flags' => $this->flags,
            'last_login_at' => $this->last_login_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'profile.name', $this->name])
            ->andFilterWhere(['like', 'profile.member_type', $this->member_type])
            ->andFilterWhere(['like', 'profile.tel', $this->tel])
            ->andFilterWhere(['like', 'profile.link', $this->link]);

        return $dataProvider;
    }
}
