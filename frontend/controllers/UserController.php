<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\City;
use frontend\models\UserEditForm;


class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'edit', 'advert'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'edit', 'advert', 'avatar-delete'],
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

    public function actionIndex($id = false)
    {

        if (!$id AND Yii::$app->user->isGuest)
            return $this->goHome();

        $user = User::find()->where(['id' => $id ? $id : Yii::$app->user->id])->with("boardCount")->with("city")->asArray()->one();

        if (!$user) return $this->goHome();

        return $this->render('index', ['model' => $user]); 

    }

    public function actionEdit($id = false)
    {

        $user = User::findOne(['id' => $id ? $id : Yii::$app->user->id]);
        if (!$user) return $this->goHome();
        
        $city = City::find()->asArray()->all();
        $model = new UserEditForm($user, $city);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Настройки успешно сохранены.');
            return $this->refresh();
        }

        return $this->render('edit', ['model' => $model, 'city' => $city]);
    }

    public function actionAvatarDelete()
    {

        $result = ['error' => "Произошла ошибка"];

        if (Yii::$app->request->isAjax AND isset(Yii::$app->user->identity->avatar)) { 
            
            $data = Yii::$app->request->post();
            $avatarPatch = Yii::getAlias('@app/web/uploads/avatar/');

            if (isset($data['key']) AND $data['key'] == Yii::$app->user->identity->avatar AND @unlink($avatarPatch . $data['key']))
            {
                $user = User::findOne(['id' => Yii::$app->user->id]);
                $user->avatar = "";
                $user->save();

                unset($result['error']);
            }       
        }

        die(json_encode($result));

    }
}
?>