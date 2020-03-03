<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\user\classes;

use common\modules\user\models\Auth;
use common\modules\user\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use common\modules\user\classes\CNSocialFunc;
use appxq\sdii\utils\VarDumper;
use yii\helpers\Url;

class AuthHandler {
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {

        $attributes = $this->client->getUserAttributes();
        VarDumper::dump($attributes);
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $username = ArrayHelper::getValue($attributes, 'name');
        $data=[];
        $clientObj = ['id'=>$id, 'getId'=> $this->client->getId()];
        if($this->client->getId() == 'facebook'){
            $data['name']=$attributes['name'];
            $data['email']=$attributes['email'];
            $data['id']=$attributes['id'];
        }else if($this->client->getId() == 'google'){
            $data['name']=$attributes['name'];
            $data['email']=$attributes['email'];
            $data['image']=$attributes['image']['url'];
        }
        VarDumper::dump($clientObj);
        $auth = CNSocialFunc::checkAuth($clientObj);
        if (\Yii::$app->user->isGuest) {
            $user = CNSocialFunc::checkUser('', $data['email']);
            if($user->blocked_at != null || $user->blocked_at != ''){
                $msg = \Yii::t('user','Your account has been blocked');
                throw new \yii\base\UserException($msg);
            }

            if($user){
                $user->confirm();
                $loginWith = $this->client->getId();
                CNSocialFunc::autoLogin($user);

            }else{
                CNSocialFunc::saveUser($data, $clientObj);
            }
        }

    }//handle

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }
    }
}
