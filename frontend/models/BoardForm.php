<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Board;
use yii\helpers\ArrayHelper;

class BoardForm extends Model
{
    public $id;
    public $category;
    public $city;
    public $user_id;
    public $title;
    public $text;
    public $price;
    public $falled;
    public $photo;
    private $_board;
    private $_city;
    private $_category;


    public function __construct($board, $city, $category)
    {
        
        $this->id = $board->id;
        $this->category = $board->category;
        $this->city = $board->city;
        $this->title = $board->title;
        $this->text = $board->text;
        $this->falled = $board->falled;
        $this->price = $board->price;

        $this->_board = $board;
        $this->_city = ArrayHelper::getColumn($city, 'id');
        $this->_category = ArrayHelper::getColumn($category, 'id');
    }

    public function rules()
    {
        return [
            [['title', 'text', 'city', 'price'], 'required'],
            ['price', 'match', 'pattern' => '/^([0-9]+)$/i'],
            ['city', 'in', 'allowArray' => true,  'range' => $this->_city],
            ['category', 'in', 'allowArray' => true,  'range' => $this->_category]
        ];
    }

    public function attributeLabels()
    {
        return [
            'category' => 'Категория',
            'city' => 'Город',
            'title' => 'Заголовок',
            'text' => 'Описание',
            'price' => 'Цена',
            'photo' => "Фото"
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $board = $this->_board;
        $board->category = $this->category;
        $board->city = $this->city;
        $board->title = $this->title;
        $board->text = $this->text;
        $board->price = $this->price;

        if ($this->_board->falled) 
        {
            $board->status = 1;
            $board->date = time();
            $board->falled = 0;
        }

        return $board->save();
    }

}

?>