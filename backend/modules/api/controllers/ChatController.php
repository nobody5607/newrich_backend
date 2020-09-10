<?php


namespace backend\modules\api\controllers;


use appxq\sdii\utils\SDdate;
use backend\modules\admins\models\Profile;
use backend\modules\games\models\Chat;
use backend\modules\games\models\Room;
use cpn\chanpan\classes\CNMessage;
use yii\db\Exception;
use yii\web\Controller;

class ChatController extends Controller
{
    private $userId;

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $origin = "*";
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        header("Access-Control-Allow-Origin: $origin", true);
        header("Access-Control-Allow-Headers: Origin,Content-Type,Authorization,x-access-token,application,uuid,version,platform");
        $this->enableCsrfValidation = false;

        $token = \Yii::$app->request->headers->get('x-access-token');
        if (!$token) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        }
        $user = $this->getUserByToken($token);
        if (!$user) {
            return CNMessage::getError("Error", "คุณไม่มีสิทธิ์ใช้งานส่วนนี้");
        } else {
            $this->userId = $user->id;
        }
        return true;
    }

    public function getUserByToken($token)
    {
        $user = \backend\modules\admins\models\User::find()->where(['auth_key' => $token])->one();
        return $user;
    }

    //get count room
    public function actionGetCountRoom()
    {
//        return $this->userId;
        $count = 0;
        $model = Room::find()->select('count(*)')->where(['friend_id' => $this->userId])->andWhere('status = 0')->scalar();
        if ($model) {
            $count = $model;
        }
        return CNMessage::getSuccess('สำเร็จ', $count);
    }

    //get room by user id
    public function actionGetRoomByFriendId()
    {
        $output = [];
        $model = Room::find()->where(['friend_id' => $this->userId])->all();
        if ($model) {
            foreach ($model as $v) {
                $profile = Profile::find()->where(['user_id' => $v->user_id])->one();
                $chat = Chat::find()->where(['room_id' => $v->id])->orderBy(['id' => SORT_DESC])->one();
                //return $profile;
                $output[] = [
                    'friend' => $profile->name,
                    'date' => SDdate::mysql2phpThDateTime($v->create_date),
                    'friend_id' => $profile->user_id,
                    'user_id' => $this->userId,
                    'msg' => isset($chat->msg) ? $chat->msg : ''
                ];
            }
        }
        return CNMessage::getSuccess('สำเร็จ', $output);
    }

    //update-status-room
    public function actionUpdateStatusRoom($id)
    {
        $model = Room::find()->where(['id' => $id])->one();
        if($model){
            $model->status = 1;
            if($model->save()){
                return CNMessage::getSuccess('สำเร็จ', $model);
            }else{
                return CNMessage::getError('เกิดข้อผิดพลาด actionUpdateStatusRoom ', $model->errors);
            }
        }
    }

    //get room
    public function actionGetRoom()
    {
        $friendId = \Yii::$app->request->get('friendId');
        try {
            $room = Room::find()
                ->where('user_id=:user_id AND friend_id=:friend_id')
                ->orWhere('friend_id=:friend_id2 AND user_id=:user_id2')
                ->addParams([
                    ':user_id' => $this->userId, ':friend_id' => $friendId,
                    ':friend_id2' => $friendId, ':user_id2' => $this->userId
                ])
                ->one();

            return CNMessage::getSuccess('สำเร็จ', $room);
        } catch (Exception $ex) {
            return CNMessage::getError('เกิดข้อผิดพลาด', $ex->getMessage());
        }
    }

    //create room
    public function actionCreateRoom()
    {
        $friendId = \Yii::$app->request->post('friendId');
        if ($friendId != '') {
            $room = new Room();
            $room->user_id = $this->userId;
            $room->friend_id = $friendId;
            $room->create_date = date('Y-m-d H:i:s');
            $room->create_by = $this->userId;
            $room->status = 0;
            if ($room->save()) {
                return CNMessage::getSuccess('สำเร็จ', $room);
            } else {
                return CNMessage::getError('เกิดข้อผิดพลาด', $room->errors);
            }
        }
    }

    //delete room
    public function actionDeleteRoom()
    {
        $friendId = \Yii::$app->request->get('friendId');
        $room = Room::find()
            ->where('user_id=:user_id AND friend_id=:friend_id')
            ->orWhere('friend_id=:friend_id2 AND user_id=:user_id2')
            ->addParams([
                ':user_id' => $this->userId, ':friend_id' => $friendId,
                ':friend_id2' => $friendId, ':user_id2' => $this->userId
            ])
            ->one();
        if ($room) {
            if ($room->delete()) {
                return CNMessage::getSuccess('สำเร็จ', $room);
            } else {
                return CNMessage::getError('เกิดข้อผิดพลาด', $room->errors);
            }
        }
        return CNMessage::getError('เกิดข้อผิดพลาดไม่พบข้อมูล');
    }


    //chat
    //get chat
    public function actionGetChat()
    {
        $roomId = \Yii::$app->request->get('roomId');
        try {
            $chat = Chat::find()
                ->where(['room_id' => $roomId])->orderBy(['id' => SORT_ASC])
                ->all();
            return CNMessage::getSuccess('สำเร็จ', $chat);
        } catch (Exception $ex) {
            return CNMessage::getError('เกิดข้อผิดพลาด', $ex->getMessage());
        }
    }

    //save chat
    public function actionSaveChat()
    {
        $roomId = \Yii::$app->request->post('roomId');
        $msg = \Yii::$app->request->post('msg');
        try {

            if ($msg != '') {
                $chat = new Chat();
                $chat->msg = $msg;
                $chat->room_id = $roomId;
                $chat->create_by = $this->userId;
                $chat->create_date = date('Y-m-d H:i:s');
                if ($chat->save()) {
                    return CNMessage::getSuccess('สำเร็จ', $chat);
                } else {
                    return CNMessage::getError('เกิดข้อผิดพลาด', $chat->errors);
                }
            }
        } catch (Exception $ex) {
            return CNMessage::getError('เกิดข้อผิดพลาด', $ex->getMessage());
        }
    }

    //get user id
    public function actionGetUserId()
    {
        return $this->userId;
    }


}
