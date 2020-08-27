<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\data\Pagination;
use common\models\Board;
use yii\helpers\ArrayHelper;

class BoardFilter extends Board
{

    public $city;
    public $category;
    public $query;
    private $_category;
    private $_city;

    public function __construct($city, $category)
    {
    //    $this->city = Yii::$app->user->identity->city;
        $this->_city = ArrayHelper::getColumn($city, 'id');
        $this->_category = ArrayHelper::getColumn($category, 'id');
    }

    public function rules()
    {
        return [
            ['city', 'in', 'allowArray' => true,  'range' => $this->_city],
            ['category', 'in', 'allowArray' => true,  'range' => $this->_category],            
            ['query', 'safe'],
            ['query', 'string', 'min' => 3, 'max' =>127],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city' => 'Город',
            'category' => 'Категория',
            'query' => 'Поиск'
        ];
    }

    public function search($params)
    {
        $load = $this->load($params);    

        if (!$this->validate()) return false;

        $query = Board::find();
        $query->where(['status' => 1]);

        if ($this->city) $query->andFilterWhere(['city' => $this->city]);
        if ($this->category) $query->andFilterWhere(['category' => $this->category]);

        if ($this->query)
        {
            $query->andFilterWhere(['like', 'title', $this->query]);
        }   

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20]);
        $board = $query->with("photo")->offset($pages->offset)->limit($pages->limit)->orderBy(["date" => SORT_DESC])->asArray()->all();

        if (!$load AND !Yii::$app->user->isGuest) $this->city = Yii::$app->user->identity->city;

        return ['board' => $board, 'pages' => $pages];

    }
}
