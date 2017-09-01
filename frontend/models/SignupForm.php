<?php
namespace frontend\models;

use yii\base\Model;
use frontend\models\User;
use borales\extensions\phoneInput\PhoneInputValidator;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const SEX_ARRAY = ['Male', 'Female'];
    const ROLE_ARRAY = ['Student', 'Teacher'];

    public $user_name;
    public $avatar;
    public $skype;
    public $phone;
    public $country;
    public $city;
    public $sex;
    public $birthday;
    public $about;
    public $interest;
    public $email;
    public $password;
    public $password_repeat;
    public $role;
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_name', 'trim'],
            ['user_name', 'required'],
            ['user_name', 'unique', 'targetClass' => 'frontend\models\User', 'message' => 'This username has already been taken.'],
            ['user_name', 'string', 'min' => 2, 'max' => 255],

            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],

            ['skype', 'trim'],
            ['skype', 'required'],
            ['skype', 'string', 'max' => 60],

            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::className()],

            ['country', 'trim'],
            ['country', 'required'],
            ['country', 'string', 'max' => 80],

            ['city', 'trim'],
            ['city', 'required'],
            ['city', 'string', 'max' => 80],

            ['sex', 'required'],
            ['sex', 'integer'],

            ['role', 'required'],
            ['role', 'integer'],

            ['birthday', 'required'],
            ['birthday', 'date', 'format' => 'yyyy-dd-mm'],

            ['about', 'string'],

            ['interest', 'string'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'frontend\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['captcha', 'captcha'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }

    public function uploadAvatar(){
        $path = 'uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension;
        $this->avatar->saveAs($path);
        return $path;
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->avatar = $this->uploadAvatar();
        $user->user_name = $this->user_name;
        $user->skype = $this->skype;
        $user->phone = $this->phone;
        $user->country = $this->country;
        $user->city = $this->city;
        $user->sex = $this->sex;
        $user->birthday = date('Y-m-d', strtotime($this->birthday));
        $user->about = $this->about;
        $user->interest = $this->interest;
        $user->email = $this->email;
        if ($this->role){
            $user->is_teacher = 1;
            $user->is_student = 0;
        }
        else{
            $user->is_teacher = 0;
            $user->is_student = 1;
        }
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }
}
