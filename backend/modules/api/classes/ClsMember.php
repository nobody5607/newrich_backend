<?phpnamespace backend\modules\api\classes;use appxq\sdii\utils\VarDumper;use common\modules\user\models\User;use yii\db\Exception;class ClsMember{    /**     * @param $id     * @param bool $showProfile     * @param bool $total     * @return array|User|\yii\db\ActiveRecord|null     */    public static function getMemberById($id,$showProfile=false, $totalStatus=true){        try{            $outptu = [];            $user = User::find()->where('id=:id',[                ':id' => $id            ])->orderBy(['id'=>SORT_DESC])->one();            unset($user->password_hash);            $avatar_base_url = isset($user->profile->avatar_base_url)?$user->profile->avatar_base_url:'';            $avatar_path = isset($user->profile->avatar_path)?$user->profile->avatar_path:'';            if(isset($user->profile->avatar_path)){                $user->profile->avatar_path = "{$avatar_base_url}/{$avatar_path}";            }            if($showProfile === true){                $orders = ClsOrder::getOrder($user->id,$totalStatus);                $outptu=[                    'user'=>$user,                    'profile'=>$user->profile,                    'order'=>$orders                ];                return $outptu;            }            return $user;        }catch (Exception $ex){        }    }    public static function getMemberAll($id,$total=true){        $users = User::find()->orderBy(['id'=>SORT_DESC])->all();        $outptu = [];        foreach ($users as $k=>$user){            $user = self::getMemberById($user->id);            unset($user->password_hash);            unset($user->auth_key);            $orders = ClsOrder::getOrder($user->id,$total);            $avatar_base_url = isset($user->profile->avatar_base_url)?$user->profile->avatar_base_url:'';            $avatar_path = isset($user->profile->avatar_path)?$user->profile->avatar_path:'';            $user->profile->avatar_path = "{$avatar_base_url}/{$avatar_path}";            $outptu[]=[                'count'=>count($users),                'user'=>$user,                'profile'=>$user->profile,                'order'=>$orders            ];        }    }}