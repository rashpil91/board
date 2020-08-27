<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $city;
    public $details;
    public $old_avatar;
    public $new_avatar;
    private $_user;
    private $_city;


    public function __construct($user, $city)
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->city = $user->city;
        $this->details = $user->details;
        $this->old_avatar = $user->avatar;
        $this->_user = $user;
        $this->_city = ArrayHelper::getColumn($city, 'id');
    }

    public function rules()
    {
        return [
            [['username', 'city', 'phone'], 'required'],
            ['details', 'trim'],
            ['phone', 'string', 'length' => 10],
            ['new_avatar', 'safe'],
            ['city', 'in', 'allowArray' => true,  'range' => $this->_city],
            ['new_avatar', 'image', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 3145728]
     
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'phone' => 'Телефон',
            'city' => 'Город',
            'details' => 'О себе',
            'avatar' => 'Фото'
        ];
    }

    public function beforeValidate()
    {
        $upload = UploadedFile::getInstance($this, 'new_avatar');
        if ($upload) $this->new_avatar = $upload;

        return true;
    }

    
    public function getAvatar()
    {

        if (is_object($this->new_avatar))
        {
            if ($this->old_avatar)
            {
                $old_avatar = Yii::getAlias('@app/web/uploads/avatar/' . $this->old_avatar);
                if (file_exists($old_avatar)) {
                    @unlink($old_avatar);
                    $this->old_avatar = false;
                }      
            }

            $image_name = strtotime("now") . "_" . Yii::$app->security->generateRandomString(5) . '.' . $this->new_avatar->extension;
            $item_image = Yii::getAlias('@app/web/uploads/avatar/' . $image_name);

            if ($this->new_avatar->saveAs($item_image)) 
            {
                Image::thumbnail($item_image, 120, 120)->save($item_image, ['quality' => 80]);
                return $image_name;

            }      
        } 
        
        return $this->old_avatar;
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = $this->_user;
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->city = $this->city;
        $user->details = $this->details;
        $user->avatar = $this->getAvatar();

        return $user->save();
    }
    
}
