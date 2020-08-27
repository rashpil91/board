<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\data\Pagination;
use common\models\Board;
use yii\helpers\ArrayHelper;

class MyBoardFilter extends Board
{

    public $status;
    public $category;
    public $query;
    private $_category;

    public function __construct($category)
    {
        $this->_category = ArrayHelper::getColumn($category, 'id');
    }

    public function rules()
    {
        return [
            ['status', 'in', 'range' => [0, 1, 2]],
            ['category', 'in', 'allowArray' => true,  'range' => $this->_category],            
            ['query', 'safe'],
            ['query', 'string', 'min' => 3, 'max' =>127],
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => 'Статус',
            'category' => 'Категория',
            'query' => 'Поиск'
        ];
    }

    public function search($params)
    {
        $load = $this->load($params);    

        if (!$this->validate()) return false;

        $query = Board::find();
        $query->where(['user_id' => Yii::$app->user->id]);
        $query->andwhere(['=', 'falled', 0]);

        if ($this->status) $query->andFilterWhere(['status' => $this->status]);
        if ($this->category) $query->andFilterWhere(['category' => $this->category]);

        if ($this->query)
        {
            $query->andFilterWhere(['like', 'title', $this->query]);
        }   

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20]);
        $board = $query->with("photo")->with("category")->with("city")->offset($pages->offset)->limit($pages->limit)->orderBy(["date" => SORT_DESC])->asArray()->all();

        return ['board' => $board, 'pages' => $pages];

    }
}
