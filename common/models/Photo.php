<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Photo extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%photo}}';
    }  

}

?>