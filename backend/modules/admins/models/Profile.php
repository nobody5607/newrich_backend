<?php

namespace backend\modules\admins\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 * @property string $firstname
 * @property string $lastname
 * @property string $tel
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property string $sitecode
 * @property string $member_type
 * @property string $link Link สำหรับแนะนำ
 * @property int $parent_id โครแนะนำมา
 * @property string $member_id
 * @property string $image
 * @property string $create_date ลงทะเบียนโดย
 * @property string $profile Profile
 * @property string $site Site
 * @property int $payment สถานะการชำระเงิน
 * @property int $pin สถานะการชำระเงิน
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'parent_id', 'payment'], 'integer'],
            [['bio', 'profile'], 'string'],
            [['create_date','pin'], 'safe'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website', 'avatar_path', 'avatar_base_url', 'link', 'image'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 40],
            [['firstname', 'lastname', 'member_type', 'member_id'], 'string', 'max' => 100],
            [['tel', 'sitecode'], 'string', 'max' => 10],
            [['site'], 'string', 'max' => 50],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'ชื่อสกุล',
            'public_email' => 'Public Email',
            'gravatar_email' => 'Gravatar Email',
            'gravatar_id' => 'Gravatar ID',
            'location' => 'Location',
            'website' => 'Website',
            'bio' => 'Bio',
            'timezone' => 'Timezone',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'avatar_path' => 'Avatar Path',
            'avatar_base_url' => 'Avatar Base Url',
            'sitecode' => 'หน่วยบริการ',

            'image' => 'Image',
            'create_date' => 'ลงทะเบียนโดย',
            'profile' => 'Profile',

            'member_type' => 'ประเภทผู้ใช้งาน',
            'link' => 'ลิงค์แนะนำ',
            'parent_id' => 'โครแนะนำมา',
            'member_id' => 'รหัสสมาชิก',
            'tel' => 'เบอร์โทรศัพท์',
            'site' => 'สาขา',
            'payment' => 'สถานะการชำระเงิน',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
