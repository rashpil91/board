<?php
namespace common\widgets;

use Yii;

use yii\base\Widget;
use yii\helpers\Html;

class Board extends Widget
{
    public $data;
    public $pages;
    public $view = "board.php";

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render("/widget/" . $this->view, ['model' => $this->data, 'pages' => $this->pages]);
    }
}

?>