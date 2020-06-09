<?php


namespace backend\models;
use yii\base\Exception;
use yii\base\Model;

class SendMail extends Model
{
    public $email;
    public $subject;
    public $message;
    public $setForm;

    public function rules()
    {
        return [
            [['subject', 'subject','message'], 'required'],
            [['setForm','email'],'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'subject' => 'หัวข้อ',
            'message' => 'ข้อความ',
        ];
    }

    public function sendMail(){
        try{
            \Yii::$app->mailer->compose('@backend/mail/layouts/app',['content'=>$this->message])
                ->setFrom($this->setForm)//->setFrom(['noreply@zmyhome.com' => 'ZmyHome HQ'])
                ->setTo($this->email)//('chanpan.nuttaphon@gmail.com')//$email
                ->setSubject($this->subject)
                ->send();
            return true;

        }catch (Exception $ex){
            return false;
        }

    }
}
