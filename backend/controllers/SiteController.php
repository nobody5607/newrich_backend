<?php
namespace backend\controllers;

use appxq\sdii\utils\SDdate;
use appxq\sdii\utils\SDUtility;
use appxq\sdii\utils\VarDumper;
use backend\models\Files;
use backend\modules\api\models\OrderDetail;
use backend\modules\api\models\Orders;
use common\modules\user\classes\CNUserFunc;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use cpn\chanpan\classes\CNMessage;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],

        ];
    }
    public function onAuthSuccess($client)
    {
        $userAttributes = $client->getUserAttributes();
        $baseUrl = isset(\Yii::$app->session['redirectUrl'])?\Yii::$app->session['redirectUrl']:'';
        //$baseUrl = 'http://newriched.com/login';
        $baseUrl = "{$baseUrl}/login";
        //VarDumper::dump($userAttributes);
        if(!$userAttributes['email']){
            return "Notfound Email!";
        }

        $user = User::getUserByEmail($userAttributes['email']);
        if($user){
            $url = "{$baseUrl}?token={$user['auth_key']}";
            return $this->redirect($url);
//            return \Yii::$app->user->login($user);
        }else{
            $user = new User();
           // $user->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $user->username = date('YmdHis'). rand(0,10000).time();
            $user->password = Yii::$app->security->generateRandomString(12);
            $user->email = isset($userAttributes['email']) ? $userAttributes['email'] : '';
            $user->created_at = time();
            $user->confirmed_at = time();
            $user->updated_at =time();
            $user->flags = 0;
            $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            if($user->save()){
                try{
                    $assignData = ['item_name'=>'user','user_id'=>$user->id, 'created_at'=> time()];
                    \Yii::$app->db->createCommand()->insert('auth_assignment', $assignData)->execute();
                } catch (\yii\db\Exception $ex){
                }
                $profile = Profile::findOne($user->id);
                $profile->user_id = $user->id;
                $profile->name = isset($userAttributes['name']) ? $userAttributes['name'] : '';
                $profile->public_email = isset($userAttributes['email']) ? $userAttributes['email'] : '';
                $profile->gravatar_email = isset($userAttributes['email']) ? $userAttributes['email'] : '';
                $profile->lastname = $userAttributes['last_name'];
                $profile->firstname = $userAttributes['first_name'];
                $profile->sitecode = '0001'; //$this->sitecode,
                $profile->site = '0001'; //$this->sitecode,
                $profile->link = 'Newrich'.Date('dmYHis').time().rand(1000000,999999999);
                if($profile->save()){
                    $user = User::getUserByEmail($userAttributes['email']);
                    $url = "{$baseUrl}?token={$user['auth_key']}";
                    return $this->redirect($url);
                    //return \Yii::$app->user->login($user);
                }

            }

        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = '@backend/modules/admins/views/layouts/admin';
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['/user/login']);
        }
        $model = new Files();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $fileName = 'uploads/' . SDUtility::getMillisecTime() . '.' . $model->file->extension;
                $model->file->saveAs($fileName);

                $objPHPExcel = \PHPExcel_IOFactory::load($fileName);
                $order = $objPHPExcel->getSheet(0)
                    ->toArray(null, true, true, true);
                $orderDetail = $objPHPExcel->getSheet(1)
                    ->toArray(null, true, true, true);
                $insert = false;

                @unlink($fileName);

                foreach($order as $k=>$v){
                    if($k<3){
                        continue;
                    }else{
                        //$user = Profile::find()->where(['member_id'=>$v['F']])->one();
                        $order = Orders::findOne((string)$v['A']);
                        $insert = false;
                        if(!$order){
                            $insert = true;
                            $order = new Orders();
                        }
                        $order->setAttributes([
                            'id'=>(string)$v['A'],
                            'user_id'=>(string)$v['F'],
                            'order'=>(string)$v['D'],
                            'score'=>(string)$v['B'],
                            'percent'=>(string)$v['C'],
                            'create_by'=>CNUserFunc::getUserId(),
                            'create_date'=>date('Y-m-d H:i:s'),
                            'rstat'=>1

                        ]);
                        if($order->save()){
                            if($insert === true){
                                foreach($orderDetail as $k2=>$d){
                                    if($k2<3){
                                        continue;
                                    }else{
                                        if($d['A'] == $d['A']){
                                            $time = strtotime($d['H']);
                                            $convertDate = date('Y-m-d',$time);

                                            $detail= new OrderDetail();
                                            $detail->order_id = (string)$d['A'];
                                            $detail->product_id = (string)$d['B'];
                                            $detail->product_name = (string)$d['C'];
                                            $detail->qty = (int)$d['D'];
                                            $detail->price = (string)$d['E'];
                                            $detail->score = $d['F'];
                                            $detail->percent = (string)$d['G'];
                                            $detail->create_date = $convertDate;
                                            $detail->create_by = CNUserFunc::getUserId();
                                            $detail->unit_price = (string)$d['I'];
                                            $detail->rstat = 1;
//                            VarDumper::dump($d);
                                            if(!$detail->save()){
                                                VarDumper::dump($detail->errors);
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            return CNMessage::getError("เกิดข้อผิดพลาด", $order->errors);
                        }
                        //end if save order
                    }

                }//end foreach order
                return CNMessage::getSuccess("อัพโหลดข้อมูลสำเร็จ");

            }
        }
        return $this->render('index',[
            'model'=>$model
        ]);
 
    }
    public function actionAbout()
    {
        return $this->render('about');
 
    }
    public function actionContact()
    {
        return $this->render('contact');
 
    }
    
    public function actionEdit()
    {
       $params = \Yii::$app->request->get('params', '');
       $model = \common\models\Options::find()->where('label=:label',[
           ':label'=>$params
       ])->one();
       if($model->load(Yii::$app->request->post()) && $model->save()){
           return \cpn\chanpan\classes\CNMessage::getSuccess('Success');
       }
       return $this->renderAjax('edit',[
           'model'=>$model,
           'params'=>$params
       ]);
 
    }
    public function actionSocial()
    {
        return $this->renderPartial('social');

    }
 
}
