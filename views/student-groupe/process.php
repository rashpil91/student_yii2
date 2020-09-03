<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

if (!$id)
{
    $this->title = 'Новая группа';
    $this->params['breadcrumbs'][] = ['label' => "Группы", 'url' => ['student-groupe/index']];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Добавить";

} else {

    $this->title = 'Редактирование группы';
    $this->params['breadcrumbs'][] = ['label' => "Группы", 'url' => ['student-groupe/index']];
    $this->params['breadcrumbs'][] = ['label' => "Группа №" . $model->number, 'url' => ['view', 'id' => $id]];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Сохранить";
}

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'form']); ?>
    <div class="row">

        <div class="col-lg-5">
            
                <?= $form->field($model, 'number')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton($save_button, ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>