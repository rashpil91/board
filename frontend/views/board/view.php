<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model['title'];
if ($model['category']) 
    $this->params['breadcrumbs'][] = ['label' => $model['category']['name'], 'url' => ['/', 'BoardFilter' => ['category' => $model['category']['id']]]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model['user']['id'] == Yii::$app->user->id AND $model['status'] == 1) :?>
        <p>
            <?= Html::a('Редактировать', ['process', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        </p>    
    <?php endif; ?>

    <div class="row">
    <div class="col-lg-5">

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'date',
                    'label' => 'Дата создания',
                    'format' => ['date','php:d M y H:i:s'],
                ], 
                [
                    'attribute' => 'city.name',
                    'label' => 'Город',
                ], 
                [
                    'attribute' => 'category.name',
                    'label' => 'Категория',
                ],

                [
                    'attribute' => 'price',
                    'label' => 'Телефон',
                    'format' => 'raw',
                    'value' => function($data){
                        return $data['price'] . " руб.";
                    }
                ],             
                [
                    'attribute' => 'avatar',
                    'label' => 'Фото',
                    'format' => 'raw',
                    'value' => function($data) {

                        if ($data['photo'])
                        {

                            $item_photo = $data['photo'][0]['filename'];
                            if (file_exists(Yii::getAlias('@app/web/uploads/board/thumbs/' . $item_photo)))
                                return Html::img("/uploads/board/thumbs/" . $item_photo);                            
                            elseif (file_exists(Yii::getAlias('@app/web/uploads/board/' . $item_photo)))
                                return Html::img("/uploads/board/" . $item_photo);

                        }

                        return "Не выбрано";
                    }
                ],         


                [
                    'attribute' => 'text',
                    'label' => 'Описание',
                ]
            ],
        ]) ?>

    </div>
    <div class="col-lg-5">
    <?= DetailView::widget([
            'model' => $user,
            'attributes' => [
                [
                    'attribute' => 'avatar',
                    'label' => 'Фото',
                    'format' => 'raw',
                    'value' => function($data){

                        if ($data['avatar'])
                        {
                            if (file_exists(Yii::getAlias('@app/web/uploads/avatar/' . $data['avatar'])))
                                return Html::img("/uploads/avatar/" . $data['avatar']);                            
                        }

                        return "Не выбрано";
                    }
                ],                
                [
                    'attribute' => 'created_at',
                    'label' => 'На сайте с',
                    'format' => ['date','php:d M y H:i:s'],
                ], 
                [
                    'attribute' => 'username',
                    'label' => 'Имя',
                ], 
                [
                    'attribute' => 'boardCount.count',
                    'label' => 'Кол-во объявлений',
                ],                 
                [
                    'attribute' => 'phone',
                    'label' => 'Телефон',
                    'format' => 'raw',
                    'value' => function($data){
                        return "+7" . $data['phone'];
                    }
                ],         

                [
                    'attribute' => 'details',
                    'label' => 'О себе',
                ]
            ],
        ]) ?>    
    </div>
    </div>

</div>    
