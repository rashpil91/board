<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Настройка профиля';
$this->params['breadcrumbs'][] = ['label' => $model->email, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$city = ArrayHelper::map($city, 'id', 'name');


$pluginOptions = [
    'initialPreviewAsData' => true,
    'previewFileType' => 'any',
    'showRemove' => false,
    'showUpload' => false,
    'maxFileSize' => 2800,
    'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
];

if ($model->old_avatar)
{
    $avatar = "/uploads/avatar/" . $model->old_avatar;
    
    if (file_exists(Yii::getAlias('@app/web/' . $avatar)))
    {
        $pluginOptions['initialPreview'] = [$avatar];
        $pluginOptions['initialPreviewConfig'] = [
            ['url' => "/user/avatar-delete", 'key' => $model->old_avatar]
        ];
    }
}

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'edit-form', 'options' => ['enctype'=>'multipart/form-data']]); ?>
    <div class="row">

        <div class="col-lg-5">
            <?= FileInput::widget([
                'model' => $model,
                'attribute' => 'new_avatar',
                'language' => 'ru',
                'options' => ['multiple' => false],         
                'pluginOptions' => $pluginOptions
            ]) ?>
        </div>

        <div class="col-lg-5">
            
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'phone') ?>

                <?= $form->field($model, 'city')->dropDownList($city) ?>

                <?= $form->field($model, 'details')->textarea(['rows' => 3]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>