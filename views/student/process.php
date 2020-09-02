<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

if ($model->falled == 1)
{
    $this->title = 'Добавление студента';
    $this->params['breadcrumbs'][] = ['label' => "Студенты", 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Добавить";

} else {

    $this->title = 'Редактирование студента';
    $this->params['breadcrumbs'][] = ['label' => "Студенты", 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => implode(" ", [$model->lastname, $model->firstname, $model->patronymic]), 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = $this->title;
    $save_button = "Сохранить";
}

$student_groupe = ArrayHelper::map($student_groupe, 'id', 'number');

$js = <<<JS

    var message_el = $(".field-photo .help-block-error");
    var message_el_parent = message_el.parents(".form-group");

    function photo_message(message) {

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

        if ($(".photo_item").length > 0) {
            
            document.getElementById("photo").value = "";
            photo_message("Фото уже загружено. Если хотите заменить, сначала удалите предыдущее.");
        
        } else {

            var formData = new FormData();

            $.each(item_el.prop('files'), function(i, item) {
                formData.append('PhotoUpload[photo][]', item);  
            })
           
            formData.append('PhotoUpload[student_id]', item_el.data("student_id"));
            formData.append("_csrf-frontend", $('[name="csrf-token"').attr('content'));

            item_el.attr("disabled", true);
            $.ajax({
                url: '/student/photo-upload',
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

        $.get("/student/photo-delete", {id: item_el.data('id')}, function(a) {
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
            
                <?= $form->field($model, 'firstname')->textInput() ?>

                <?= $form->field($model, 'lastname')->textInput() ?>

                <?= $form->field($model, 'patronymic')->textInput() ?>

                <?= $form->field($model, 'student_groupe')->dropDownList($student_groupe) ?>

                <?= $form->field($model, 'photo[]', ['inputOptions' => ['id' => 'photo', 'data-student_id' => $model->id]])->fileInput(['multiple'=>'multiple'])->hint("Размер картинки не более 3 мб") ?>

                <div id="photo_list">
                    <?php Pjax::begin(['id'=>'id-pjax']); ?>
                        <?= $this->render("photo", ['model' => $model]); ?>
                    <?php Pjax::end(); ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($save_button, ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>