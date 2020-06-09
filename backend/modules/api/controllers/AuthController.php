<?php


namespace backend\modules\api\controllers;


use appxq\sdii\utils\SDUtility;
use appxq\sdii\utils\VarDumper;
use backend\modules\api\classes\ClsAuth;
use backend\modules\api\classes\ClsMember;
use backend\modules\api\models\Orders;
use common\modules\user\classes\CNAuth;
use common\modules\user\models\Profile;
use cpn\chanpan\classes\CNMessage;
use mdm\admin\models\User;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        $origin = "*";
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        header("Access-Control-Allow-Origin: $origin", true);
        header("Access-Control-Allow-Headers: Origin,Content-Type,Authorization,x-access-token,application,uuid,version,platform");
        $this->enableCsrfValidation = false;
        return true;
    }

    public function actionSocialLogin()
    {
        $email = \Yii::$app->request->post('email');
        $name = \Yii::$app->request->post('name');
        $id = \Yii::$app->request->post('id');
        $link = \Yii::$app->request->post('link');
        $linkCurrent = 'Newrich' . Date('dmYHis') . time() . rand(1000000, 999999999);
        $profile = Profile::find()->where('link=:link', [
            ':link' => $link
        ])->one();

        $user = ClsAuth::getUserByEmail($email);
        if ($user) {
            $member = ClsMember::getMemberById($user->id, true);
            return CNMessage::getSuccess("Success", $member);
        } else {
            $data = [
                'email' => $email,
                'password' => SDUtility::getMillisecTime(),
                'firstname' => $name,
                'lastname' => $name,
                'name' => $name,
                'member_id' => 'newrich',
                'linkCurrent' => $linkCurrent,
                'member_type' => 'B2B',
                'parent_id' => $profile->user_id,
                'tel' => ''

            ];
            $data = ClsAuth::saveUser($data);
            if ($data['status'] == 'success') {
                $member = ClsMember::getMemberById($data['data']['id'], true);
                return CNMessage::getSuccess("Login สำเร็จ", $member);
            } else {
                return CNMessage::getError("Error กรุณาตรวจสอบข้อมูลของท่าน", $data);
            }
        }

    }

    public function actionRegister()
    {
        $email = \Yii::$app->request->post('email');
        $password = \Yii::$app->request->post('password');
        $firstname = \Yii::$app->request->post('firstname');
        $lastname = \Yii::$app->request->post('lastname');
        $member_id = \Yii::$app->request->post('member_id');
        $member_type = \Yii::$app->request->post('member_type');
        $site = \Yii::$app->request->post('site');

        $tel = \Yii::$app->request->post('tel');
        $link = \Yii::$app->request->post('link');
        $linkCurrent = 'Newrich' . Date('dmYHis') . time() . rand(1000000, 999999999);

        $profile = Profile::find()->where('link=:link', [
            ':link' => $link
        ])->one();
        if (ClsAuth::checkEmail($email)) {
            return CNMessage::getError("Email {$email} ถูกใช้งานแล้ว");
        }
        $data = [
            'email' => $email,
            'password' => $password,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'name' => "{$firstname} {$lastname}",
            'member_id' => $member_id,
            'linkCurrent' => $linkCurrent,
            'member_type' => $member_type,
            'parent_id' => isset($profile->user_id) ? $profile->user_id : '',
            'tel' => $tel,
            'sitecode' => $site,
        ];
        $data = ClsAuth::saveUser($data);


        if ($data['status'] == 'success') {
            return CNMessage::getSuccess("สมัครสมาชิกสำเร็จ");
        } else {
            return CNMessage::getError("Error กรุณาตรวจสอบข้อมูลของท่าน", $data['message']);
        }

    }

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $name = \Yii::$app->request->post('name');
        $email = \Yii::$app->request->post('email');
        $image = \Yii::$app->request->post('image');
        $link = \Yii::$app->request->post('link');
        $site = \Yii::$app->request->post('site', '0001');

        $user = \backend\modules\admins\models\User::find()->where(['email' => $email])->one();

        if ($user) {
            return $user;
        }else{
            $user->username = date('YmdHis') . rand(0, 10000) . time();
            $user->password = Yii::$app->security->generateRandomString(12);
            $user->email = $email;
            $user->created_at = time();
            $user->confirmed_at = time();
            $user->updated_at = time();
            $user->flags = 0;
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            if ($user->save()) {
                $memberParent = Profile::find()->where(['link'=>$link])->one();
                try {
                    $assignData = ['item_name' => 'user', 'user_id' => $user->id, 'created_at' => time()];
                    \Yii::$app->db->createCommand()->insert('auth_assignment', $assignData)->execute();
                } catch (\yii\db\Exception $ex) {}
                $profile = Profile::findOne($user->id);
                $profile->user_id = $user->id;
                $profile->name = $name;
                $profile->public_email = $email;
                $profile->gravatar_email = $email;
                $nameObj = explode(' ', $name);
                $profile->lastname = issett($nameObj[0]) ? $nameObj[0] : '';
                $profile->firstname = isset($nameObj[1]) ? $nameObj[1] : '';
                $profile->sitecode = $site;
                $profile->site = $site;
                $profile->avatar_path = $image;
                $profile->parent_id = isset($memberParent->user_id) ? $memberParent->user_id : '';
                $profile->member_type = 'B2B';
                $profile->link = 'Newrich' . Date('dmYHis') . time() . rand(1000000, 999999999);
                if ($profile->save()) {
                    return $user->auth_key;
                } else {
                    return false;
                }

            }
        }
    }

    public function actionLoginByToken($token)
    {
        $user = \common\modules\user\models\User::find()
            ->where('auth_key=:token')->addParams([':token' => $token])->one();
        if ($user) {
            $member = ClsMember::getMemberById($user->id, true);
            return CNMessage::getSuccess("Success", $member);
        } else {
            return CNMessage::getError("ไม่พบผู้ใช้งาน");
        }

    }

    public function actionGetProfile()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $totalStatus = \Yii::$app->request->get('total', true);
        $user = ClsAuth::getUserByToken($token);
        $member = ClsMember::getMemberById($user->id, true, $totalStatus);


        $output = [
            'id' => $member['user']['id'],
            'email' => $member['user']['email'],
            'token' => $member['user']['auth_key'],
            'name' => $member['profile']['name'],
            'image' => $member['profile']['avatar_path'],
            'site' => $member['profile']['site'],
            'member_type' => $member['profile']['member_type'],
            'member_id' => $member['profile']['member_id'],
            'link' => $member['profile']['link'],
            'pin' => $member['profile']['pin'],
        ];
        $money = Orders::find()
            ->where(['user_id' => $member['profile']['member_id']])
            ->andWhere("payment is null OR payment = ''")->sum('percent');
        if ($money == '') {
            $money = 0;
        }
        $output['money'] = $money;
        return Json::encode($output);
        return CNMessage::getSuccess("Success", $output);
    }


    public function actionMyProfile()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');

        $totalStatus = \Yii::$app->request->get('total', true);
        $user = ClsAuth::getUserByToken($token);
        //
        $profile = Profile::find()->where('user_id=:user_id', [
            ':user_id' => $user['id']
        ])->one();
        return CNMessage::getSuccess("Success", $profile);

    }

    public function actionChangePassword()
    {
        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = ClsAuth::getUserByToken($token);
        if (!$user) {
            return CNMessage::getError("Error", "ไม่พบผู้ใช้งาน");
        }
        $password = \Yii::$app->request->post('password');
        $newpassword = \Yii::$app->request->post('new_password');


//        $user->password = $user->setPassword($newpassword);
//        if($user->save()){
//            return CNMessage::getSuccess("Success",'เปลี่ยนรหัสผ่านสำเร็จ');
//        }else{
//            return CNMessage::getError("Success",'เปลี่ยนรหัสผ่านไม่สำเร็จเนื่องจาก',$user->errors);
//        }

        if (\Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            $user->password = $user->setPassword($newpassword);
            if ($user->save()) {
                return CNMessage::getSuccess("Success", 'เปลี่ยนรหัสผ่านสำเร็จ');
            } else {
                return CNMessage::getError("Success", 'เปลี่ยนรหัสผ่านไม่สำเร็จเนื่องจาก', $user->errors);
            }
        } else {
            return CNMessage::getError("Success", 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
        }
    }

    public function actionUpdateMyProfile()
    {


        if (isset($_POST) && !empty($_POST)) {
            $token = \Yii::$app->request->headers->get('x-access-token');
            $user = ClsAuth::getUserByToken($token);
            $profile = Profile::find()
                ->where('user_id=:user_id', [
                    ':user_id' => $user->id
                ])->one();
            $name = \Yii::$app->request->post('name');
            $member_id = \Yii::$app->request->post('member_id');
            $member_type = \Yii::$app->request->post('member_type');
            $tel = \Yii::$app->request->post('tel');
            $profileDetail = \Yii::$app->request->post('profile');

            if ($name == 'undefined') {
                $name = '';
            }
            if ($member_id == 'undefined') {
                $member_id = '';
            }
            if ($member_type == 'undefined') {
                $member_type = '';
            }
            if ($tel == 'undefined') {
                $tel = '';
            }

            //upload image
            $image = UploadedFile::getInstancesByName('image');
            $dataImage = "";
            if ($image) {
                $file = $image[0];
                $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                $folder = "/web/uploads/";
                $path = \Yii::getAlias('@storage') . "{$folder}";
                $type = $file->extension;
                $filePath = "{$path}/{$realFileName}.{$type}";
                if ($file->saveAs("{$filePath}")) {
                    $fileName = "{$realFileName}.{$type}";
                    $dataImage = $fileName;

                    try {
                        $sql = "update profile set avatar_path=:image where user_id=:user_id";
                        $params = [':image' => $dataImage, ':user_id' => $user->id];
                        \Yii::$app->db->createCommand($sql, $params)->execute();
                    } catch (\Exception $ex) {
                    }
                }
            } else {
                $dataImage = isset($profile->avatar_path) ? $profile->avatar_path : '';

            }
            $profile->name = $name;
            $profile->member_id = $member_id;
            $profile->member_type = $member_type;
            $profile->tel = $tel;
            $profile->profile = $profileDetail;
            if ($profile->save()) {
                //return $dataImage;
                $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
                $avatar_path = "{$storageUrl}/uploads/{$dataImage}";
                return CNMessage::getSuccess("แก้ไขโปรไฟล์สำเร็จ", ['image' => $avatar_path]);
            } else {
                return CNMessage::getError("Error", $profile->errors);
            }

        }
    }
}
