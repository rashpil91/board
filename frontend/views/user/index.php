<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

$this->title =  $model['email'];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="user-view">

    <h1>Просмотр профиля</h1>

    <?php if ($model['id'] == Yii::$app->user->id): ?>
        <p>
            <?= Html::a('Редактировать', ['edit'], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'avatar',
                'label' => 'Аватар',
                'format' => 'raw',
                'value' => function($data) {
                    return $data['avatar'] ? Html::img("/uploads/avatar/" . $data['avatar']) : "Не выбран";
                }
            ],         
            [
                'attribute' => 'username',
                'label' => 'Имя',
            ],
            [
                'attribute' => 'email',
                'label' => 'Емайл',
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
                'attribute' => 'city.name',
                'label' => 'Город',
            ],
            [
                'attribute' => 'boardCount.count',
                'label' => 'Кол-во объявления',
            ],            
            [
                'attribute' => 'details',
                'label' => 'О себе',
            ],
        
                       
            [
                'attribute' => 'created_at',
                'label' => 'Дата регистрации',
                'format' => ['date','php:d M y H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Последний визит',
                'format' => ['date','php:d M y H:i:s'],
            ]
        ],
    ]) ?>

</div>
