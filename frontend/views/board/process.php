<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

if ($model->falled == 1)
{
    $this->title = 'Добавление объявления';
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Добавить";

} else {

    $this->title = 'Изменить объявление';
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Сохранить";
}

$city = ArrayHelper::map($city, 'id', 'name');
$category = ArrayHelper::map($category, 'id', 'name');

$limit = 1;

$js = <<<JS

    var message_el = $(".field-photo .help-block-error");
    var message_el_parent = message_el.parents(".form-group");

    console.log(message_el.attr("class"));

    function photo_message(message) {
        
        console.log(typeof(message));

        if (typeof(message) == "string") {
            message_el.text(message);
            message_el_parent.addClass("has-error");
        } else if (typeof(message) == "object") {

            let select = $("<ul>");

            $.each(message, function(element, errors) {
                $.each(errors, function(i, error) {
                    select.append($("<li>").text(error));
                });
            });

            message_el.html(select);
            message_el_parent.addClass("has-error");
        }
    } 

    function photo_message_clear() {
        message_el_parent.removeClass("has-error");
        message_el.empty();
    }

    $("#photo").change(function()
    {
        let item_el = $(this);
        photo_message_clear();

        if ($(".photo_item").length > {$limit}) {
            
            document.getElementById("photo").value = "";
            photo_message("Вы уже загрузили фото. Максимальное количество: " + {$limit});

        } else if ((item_el.prop('files').length + $(".photo_item").length) > {$limit}) {

            document.getElementById("photo").value = "";
            photo_message("Вы выбрали слишком много фото. Максимальное количество: " + {$limit});
        
        } else {

            var formData = new FormData();

            $.each(item_el.prop('files'), function(i, item) {
                formData.append('PhotoUpload[photo][]', item);  
            })
           
            formData.append('PhotoUpload[board_id]', item_el.data("board_id"));
            formData.append("_csrf-frontend", $('[name="csrf-token"').attr('content'));

            item_el.attr("disabled", true);
            $.ajax({
                url: '/board/photo-upload',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                type: 'POST',
                success: function(data) {
                    item_el.attr("disabled", false);
                    data = JSON.parse(data);

                    if (data.status == "ok")
                    {
                        $.pjax.reload({container: '#id-pjax'});

                    } else {

                        document.getElementById("photo").value = "";
                        photo_message(data.errors);

                    }
                        
                    
                }
            });
        }

        return false;

    });

JS;
$position = $this::POS_READY;
$this->registerJs($js, $position);

$js = <<<JS

    $(document).on("click", ".photo_delete",  function() {

        item_el = $(this);

        $.get("/board/photo-delete", {id: item_el.data('id')}, function(a) {
            if (a.status == "ok")   
                item_el.parents(".photo_item").remove();
            else
                console.log(a.error);
        }, "JSON");

        return false;
    });  

JS;
$position = $this::POS_READY;
$this->registerJs($js);
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'form', 'options' => ['enctype'=>'multipart/form-data']]); ?>
    <div class="row">

        <div class="col-lg-5">
            
                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'category')->dropDownList($category) ?>

                <?= $form->field($model, 'text')->textarea(['rows' => 4]) ?>

                <?= $form->field($model, 'city')->dropDownList($city) ?>

                <?= $form->field($model, 'price') ?>

                <?= $form->field($model, 'photo[]', ['inputOptions' => ['id' => 'photo', 'data-board_id' => $model->id]])->fileInput(['multiple'=>'multiple'])->hint("Размер картинки не более 10 мб") ?>

                <div id="photo_list">
                    <?php Pjax::begin(['id'=>'id-pjax']); ?>
                        <?= $this->render("photo", ['photo' => $photo]); ?>
                    <?php Pjax::end(); ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($save_button, ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>