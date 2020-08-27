<?php

use yii\bootstrap\ActiveForm;
use common\widgets\Board;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Доска объявлений';

$city = ArrayHelper::map($city, 'id', 'name');
$category = ArrayHelper::map($category, 'id', 'name');

?>
<div class="site-index">

    <div class="jumbotron">
        <?php $form = ActiveForm::begin(['id' => 'filter', 'action' => "index.php", 'method' => 'get', 'options' => ['class' => "form-inline"]]); ?>

        <?= $form->field($filter, 'category')->dropDownList($category) ?>

        <?= $form->field($filter, 'city')->dropDownList($city) ?>

        <?= $form->field($filter, 'query')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton("Поиск", ['class' => 'btn btn-primary', 'name' => 'search-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="body-content">        
        <?= Board::widget(['data' => $board, 'pages' => $pages]) ?>
    </div>
</div>
