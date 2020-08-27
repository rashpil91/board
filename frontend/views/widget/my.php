<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$status = ['1' => "Активное", 2 => "Закрытое"];

?>

<?php if ($model): ?>
<div class="row">
    <?php foreach ($model as $k => $v): ?>


    <div class="media">
        <div class="media-body">
            <h4 class="media-heading">
                <?= Html::a($v['title'], ['board/view', 'id' => $v['id']] ); ?>
                <?php
                    if ($v['status'] == 1) {
                        echo Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['board/process', 'id' => $v['id']] );
                          echo Html::a("Закрыть", ['close', 'id' => $v['id']], ['class' => "btn btn-primary"]);
                    }
                ?>
            </h4>
            <div class="form-inline">
                <span>Цена: <?= Yii::$app->formatter->asDatetime($v['date'], "dd MMMM в HH:mm"); ?> руб.</span>
                <span>Категория: <?= $v['category']['name'] ?></span>
                <span>Город: <?= $v['city']['name'] ?> руб.</span>
            </div>
            <p><?= $v['text'] ?></p>
        </div>
 
        <div class="media-right">
            <p>Статус: <?= $status[$v['status']]; ?></p>
            <p>Цена: <?= $v['price'] ?> руб.</p>
            <a href="#">
                <?php
                    if ($v['photo'])
                    {
                        if (file_exists(Yii::getAlias('@app/web/uploads/board/thumbs/' . $v['photo'][0]['filename'])))
                            echo Html::img("/uploads/board/thumbs/" . $v['photo'][0]['filename']);                            
                        elseif (file_exists(Yii::getAlias('@app/web/uploads/board/' . $v['photo'][0]['filename'])))
                            echo Html::img("/uploads/board/" . $v['photo'][0]['filename']);                        
                        else
                            echo Html::img("/uploads/board/noimage.png"); 
                    } else
                        echo Html::img("/uploads/board/noimage.png");

                ?>
            </a>
        </div>

    </div>

    <?php endforeach; ?>
</div>

<div class="row">
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>

<?php else: ?>
    <div class="panel panel-default">
    <div class="panel-body">
        Объявлений нет
    </div>
    </div>
<?php endif; ?>