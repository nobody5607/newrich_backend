<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\user\classes;

use appxq\sdii\utils\VarDumper;
use common\modules\user\models\Profile;

/**
 * Description of CNUser
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class CNUserFunc {
    public static function getFullNameByUserId($user_id){
        $profile = Profile::findOne($user_id);
        $fullName = null;
        $fname = null;
        $lname = null;
        if($profile){
            $fname = isset($profile->firstname)?$profile->firstname:'';
            $lname = isset($profile->lastname)?$profile->lastname:'';
            $fullName = "{$fname} {$lname}";
        }
        return $fullName;
    }
    public static function getUserId(){
        return isset(\Yii::$app->user->id)?\Yii::$app->user->id:'';
    }
    public static function getSitecode(){
        $sitecode = isset(\Yii::$app->user->identity->profile->sitecode)?\Yii::$app->user->identity->profile->sitecode:'';
        return $sitecode;
    }
    public static function getUserById($type, $user_id){        
        return CNUserQuery::getUserById($type, $user_id);
    }
    public static function createUser($type,$user){        
        return CNUserQuery::saveUser($type, $user);
    }
    public static function checkUser($field, $values){
        $data = \common\modules\user\models\User::find();
        if($field=="email"){
            $user = $data->where('email=:email', [':email'=>$values]);
        }else if($field=="username"){
            $user = $data->where('username=:username', [':username'=>$values]);
        }
        return $user->one();
        
    }
}
