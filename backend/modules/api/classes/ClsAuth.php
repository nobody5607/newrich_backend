<?phpnamespace backend\modules\api\classes;use common\modules\user\models\Profile;use mdm\admin\models\User;use Yii;class ClsAuth{    public static function checkEmail($email){        $user = \common\modules\user\models\User::find()->where('email=:email',[            ':email' => $email        ])->one();        if($user){            return true;        }else{            return false;        }    }    public static function getUserByToken($token){        $user = \common\modules\user\models\User::find()->where('auth_key=:token',[            ':token' => $token        ])->one();        return $user;    }    public static function Login($username, $password)    {        try {            $user = User::find()                ->where('username=:username OR email=:email',[                    ':username' => $username,                    ':email' => $username                ])                ->one();            if($user){                if(\Yii::$app->getSecurity()->validatePassword($password, $user['password_hash'])){                    return ['status'=>'success','data'=>$user];                }            }        } catch (\Exception $e) {            return ['status'=>'success','message'=>$e->getMessage()];        }    }    public static function saveUser($data){        try{            $user = new \common\modules\user\models\User();            $user->id = time();            $user->username = date('YmdHis'). rand(0,10000).time();            $user->password = $user->setPassword($data['password']);//\Yii::$app->security->generatePasswordHash($data['password']);            $user->email = isset($data['email']) ? $data['email'] : '';            $user->created_at = time();            $user->confirmed_at = time();            $user->updated_at =time();            //$user->password_hash = \Yii::$app->security->generatePasswordHash($data['password']);//            return $user->password_hash;//\Yii::$app->security->generatePasswordHash($data['password'], 12);            $user->auth_key = Yii::$app->security->generateRandomString();            if($user->save()){                try{                    $statusProfile = self::saveProfile($data, $user->id);                    if($statusProfile['status'] == 'success'){                        $assignData = ['item_name'=>'user','user_id'=>$user->id, 'created_at'=> time()];                        Yii::$app->db->createCommand()->insert('auth_assignment', $assignData)->execute();                    }else{                        $dataStatus=['status'=>'error','message'=>$statusProfile['message']];                    }                   } catch (\yii\db\Exception $ex){                    $dataStatus=['status'=>'error','message'=>$ex->getMessage()];                }                $dataStatus=['status'=>'success','data'=>$user];            }else{                $dataStatus=['status'=>'error','message'=>$user->errors];            }        } catch (\yii\db\Exception $ex) {            $dataStatus=['status'=>'error','message'=>$ex->getMessage()];        }        return $dataStatus;    }    /**     *     * @param type $data array $data=['email'=>'', 'name'=>'']     * @param type $user_id     * @return boolean true/false     */    public static function saveProfile($data, $user_id){        $profile = Profile::findOne($user_id);        $profile->user_id = $user_id;        $profile->name = isset($data['name']) ? $data['name'] : '';        $profile->public_email = isset($data['email']) ? $data['email'] : '';        $profile->gravatar_email = isset($data['email']) ? $data['email'] : '';        $profile->firstname = isset($data['firstname'])?$data['firstname']:'';        $profile->lastname = isset($data['lastname'])?$data['lastname']:'';        $profile->sitecode = '00';        $profile->tel = isset($data['tel'])?$data['tel']:'';        $profile->link = isset($data['linkCurrent'])?$data['linkCurrent']:'';        $profile->member_type = isset($data['member_type'])?$data['member_type']:'';        $profile->parent_id = isset($data['parent_id'])?$data['parent_id']:'';        $profile->member_id = isset($data['member_id'])?$data['member_id']:'';        if($profile->save()){            return ['status'=>'success'];        }else{            return ['status'=>'error','message'=>$profile->errors];        }    }}