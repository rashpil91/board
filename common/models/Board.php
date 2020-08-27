<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Board extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%board}}';
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city']);
    }    

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }   

    public function getPhoto()
    {
        return $this->hasMany(Photo::className(), ['board_id' => 'id']);
    }   

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }   


}

?>