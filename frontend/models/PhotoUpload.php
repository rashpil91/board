<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Photo;
use common\models\Board;
use yii\web\UploadedFile;
use yii\imagine\Image;

class PhotoUpload extends Model
{
    public $board_id;
    public $photo;
    private $limit = 1;

    public function rules()
    {
        return [
            ['board_id', 'integer'],
            [['board_id'], 'required'],
            ['board_id', 'board_check'],
            ['photo', 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10485760, 'maxFiles' => $this->limit, 'checkExtensionByMimeType' => false],
        ];
    }      

    public function board_check($attribute, $param)
    {
        
        if (!Board::find()->where(['id' => $this->$attribute])->count())
        {
            $this->addError($this->attribute, "Ошибка при передаче данных");
            return false;
        }    

        return true;
    }

    public function beforeValidate()
    {
        $photo = UploadedFile::getInstances($this, 'photo');
        if ($photo) $this->photo = $this->limit == 1 ? $photo[0] : $photo;

        return true;
    }

    private function loadImage($item)
    {
        
        $image_name = strtotime("now") . "_" . Yii::$app->security->generateRandomString(5) . '.' . $item->extension;
        $item_image = Yii::getAlias('@app/web/uploads/board/' . $image_name);
        $item_image_thumb = Yii::getAlias('@app/web/uploads/board/thumbs/' . $image_name);

        if ($item->saveAs($item_image)) 
        {
            Image::thumbnail($item_image, null, 200)->save($item_image_thumb, ['quality' => 80]);
            Image::thumbnail($item_image, 800, null)->save($item_image, ['quality' => 80]);
            return $image_name;
        } 

        return false;

    }

    private function uploadImage()
    {

        $photo = [];

        if (is_array($this->photo))
        {
        
            foreach ($this->photo as $k => $item)
            {
                $image_name = $this->loadImage($item);
                if ($image_name)  $photo[] = $image_name;
            } 

        } else {

            $image_name = $this->loadImage($this->photo);
            if ($image_name)  $photo[] = $image_name;

        }
       
        return $photo;
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $photo = $this->uploadImage();

        if ($photo)
        {
            foreach ($photo as $image_name)
            {
                $photo = new Photo();
                $photo->board_id = $this->board_id;
                $photo->date = time();
                $photo->filename = $image_name;
                $photo->save();
            }

            return true;
        }

        return false;
    }    

}