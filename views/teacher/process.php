<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

if ($new)
{
    $this->title = 'Добавление преподавателя';
    $this->params['breadcrumbs'][] = ['label' => "Преподаватели", 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Добавить";

} else {

    $this->title = 'Редактирование преподавателя';
    $this->params['breadcrumbs'][] = ['label' => "Преподаватели", 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => implode(" ", [$model->lastname, $model->firstname, $model->patronymic]), 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Сохранить";
}

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'form']); ?>
    <div class="row">

        <div class="col-lg-5">

                <?= $form->field($model, 'lastname')->textInput() ?>

                <?= $form->field($model, 'firstname')->textInput() ?>

                <?= $form->field($model, 'patronymic')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton($save_button, ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>