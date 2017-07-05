<?php
namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $nickname;
    public $password;
    public $password_repeat;
    public $profile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '邮箱地址已存在'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat','compare','compareAttribute' => 'password','message' => '两次输入密码不一致'],

            ['nickname','required'],
            ['nickname','string','max' => 128],

            ['profile','string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '匿名',
            'password' => '密码',
            'password_repeat' => '重置密码',
            'email' => '邮箱',
            'profile' => '简述',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Adminuser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->nickname = $this->nickname;
        $user->profile = $this->profile;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        //echo '<pre>';
        //var_dump($user);die;
        //$re = $user->save();
        //var_dump($user->errors);die;
        
        return $user->save() ? $user : null;
    }
}
