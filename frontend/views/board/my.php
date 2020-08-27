<?php

use yii\bootstrap\ActiveForm;
use common\widgets\Board;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Мои объявления';

$category = ArrayHelper::map($category, 'id', 'name');

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="jumbotron">
        <?php $form = ActiveForm::begin(['id' => 'filter', 'action' => "/board/my", 'method' => 'get', 'options' => ['class' => "form-inline"]]); ?>

        <?= $form->field($filter, 'category')->dropDownList($category) ?>

        <?= $form->field($filter, 'status')->dropDownList([0 => "", 1 => "Активные", 2 => "Закрытые"]) ?>

        <?= $form->field($filter, 'query')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton("Поиск", ['class' => 'btn btn-primary', 'name' => 'search-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="body-content">        
        <?= Board::widget(['data' => $board, 'pages' => $pages, 'view' => "my.php"]) ?>
    </div>
</div>
