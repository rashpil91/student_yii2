<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

if (empty($id))
{
    $this->title = 'Записать группу на курс';
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Добавить";

} else {

    $this->title = 'Редактирование группы';
//    $this->params['breadcrumbs'][] = ['label' => "Группа №" . $model->number, 'url' => ['view', 'id' => $id]];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Сохранить";
}

$student_groupe = ArrayHelper::map($student_groupe, 'id', 'number');
$course = ArrayHelper::map($course, 'id', 'name');

$teacher_formated = [];
foreach ($teacher as $k => $el)
{
    $teacher_formated[$el['id']] = implode(" ", [$el['lastname'], $el['firstname'], $el['patronymic']]);
}    

$teacher = $teacher_formated;


?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'form']); ?>
    <div class="row">

        <div class="col-lg-5">
            
                <?= $form->field($model, 'student_groupe')->dropDownList($student_groupe) ?>

                <?= $form->field($model, 'course')->dropDownList($course) ?>

                <?= $form->field($model, 'teacher')->dropDownList($teacher) ?>

                <?= $form->field($model, 'status')->dropDownList($status) ?>

                <div class="form-group">
                    <?= Html::submitButton($save_button, ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>