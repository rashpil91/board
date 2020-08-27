<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<?php if ($model): ?>
<div class="row">
    <?php foreach ($model as $k => $v): ?>
        <div class="col-lg-4">
            <p>
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
            </p>
            <p><?= Html::a($v['title'], ['board/view', 'id' => $v['id']] ); ?></p>
            <p>Цена: <?= $v['price'] ?> руб.</p>
            <p><?= date("Y.m.d", $v['date']) ?></p>
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