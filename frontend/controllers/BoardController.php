<?php
namespace frontend\controllers;

use frontend\models\BoardForm;
use frontend\models\MyBoardFilter;
use frontend\models\PhotoUpload;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\City;
use common\models\Category;
use common\models\Board;
use common\models\Photo;

class BoardController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'process', 'my'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['view', 'process', 'my'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionProcess($id = false)
    {

        if (!$id)
        {
            $board = new Board();
            $board->falled = 1;
            $board->user_id = Yii::$app->user->id;
            $board->save();
            
            return $this->redirect(['process', 'id' => $board->id]);

        } else 
            $board = Board::findOne(['id' => $id]);

        if (!$board OR $board->user_id != Yii::$app->user->id OR (!$board->falled AND $board->status != 1)) return $this->goHome();

        $falled = $board->falled;
        $city = City::find()->asArray()->all();
        $category = Category::find()->asArray()->all();
        array_unshift($category, [0 => ""]);
        $photo = Photo::find()->where(['board_id' => $id])->asArray()->all();

        $model = new BoardForm($board, $city, $category);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($falled)
            {
                Yii::$app->session->setFlash('success', 'Объявление успешно добавлено');
                return $this->redirect(['view', 'id' => $board->id]);

            } else {
                Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
                return $this->refresh();
            }

        }

        return $this->render('process', ['model' => $model, 'category' => $category, 'city' => $city, 'photo' => $photo]);
    }

    public function actionMy()
    {
     
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        $category = Category::find()->asArray()->all();
        array_unshift($category, [0 => ""]);
        $filter = new MyBoardFilter( $category);

        $data = $filter->search(Yii::$app->request->queryParams);

        return $this->render('my', [
            'filter' => $filter, 
            'category' => $category,
            'board' => $data['board'],
            'pages' => $data['pages']
        ]);
    }

    public function actionClose($id)
    {
        $board = Board::find()->where(['id' => $id])->one();

        if ($board AND $board->status == 1 AND $board->user_id == Yii::$app->user->id)
        {
            $board->status = 2;
            $board->save();

            Yii::$app->session->setFlash('success', 'Объявление успешно закрыто');
            return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null)); 
        }

        return $this->goHome();
    }

    public function actionView($id)
    {

        $board = Board::find()->where(['id' => $id])->with("user")->with("photo")->with("category")->with("city")->asArray()->one();
        $user = User::find()->where(['id' => $board['user_id']])->with("boardCount")->asArray()->one();

        return $this->render('view', ['model' => $board, 'user' => $user]);
    }


    public function actionPhotoUpload()
    {

        $result = ['status' => "error"];
        $model = new PhotoUpload();
 
        if ($model->load(Yii::$app->request->post()) && $model->save())
            $result['status'] = "ok";
        else
            $result['errors'] = $model->errors;

        die(json_encode($result));
    }

    public function actionPhotoDelete($id)
    {
        
        $photo = (new \yii\db\Query())->select(['filename', 'user_id'])->from("photo p")->join("LEFT JOIN", "board b", "board_id = b.id")->where(['p.id' => $id])->one();

        $result['status'] = "error";

        if ($photo AND $photo['user_id'] == Yii::$app->user->id)
        {

            if ($photo['filename'])
            {

                $item_image = Yii::getAlias('@app/web/uploads/board/' . $photo['filename']);
                $item_image_thumb = Yii::getAlias('@app/web/uploads/board/thumbs/' . $photo['filename']);

                if (file_exists($item_image)) @unlink($item_image);
                if (file_exists($item_image_thumb)) @unlink($item_image_thumb);
            }

            Photo::deleteAll(['id' => $id]);
            $result['status'] = "ok";

        } else
            $result['message'] = "Ошибка при передаче данных";
        
        die(json_encode($result));
    }

}
?>