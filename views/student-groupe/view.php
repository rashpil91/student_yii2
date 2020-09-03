<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use app\models\Photo;

$this->title = 'Группа № ' . $student_groupe['number'];
$this->params['breadcrumbs'][] = ['label' => "Группы", 'url' => ['student-groupe/index']];
$this->params['breadcrumbs'][] = $this->title;


$dataProvider = new ArrayDataProvider([
    'allModels' => $student_groupe['sgct'],
]);

$dataProviderStudent = new ArrayDataProvider([
    'allModels' => $student_groupe['student'],
]);
?>

<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <div class="btn-group">
                <?= Html::a('Редактировать', ['process', 'id' => $student_groupe['id']], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $student_groupe['id']], ['class' => 'btn btn-danger', 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) ?>
            </div>
        </p>


        <h1>Изучает курсы</h1>


<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [       
        [
            'class'     => DataColumn::className(),
            'attribute' => 'courses.name',
            'label'     =>'Название курса',
            'format' => "raw",
            'value' => function($data) 
            {
                return Html::a($data['courses']['name'], ['course/view', 'id' => $data['courses']['id']], ['target' => '_blank']);
            }
        ],
        [
            'class'     => DataColumn::className(),
            'attribute' => 'courses.time',
            'filter' => true,
            'label'     =>'Продолжительность'
        ], 
        [
            'attribute' => 'teacher',
            'label' => 'Преподаватель',
            'format' => "raw",
            'value' => function($data) 
            {
                return Html::a(implode(" ", [$data['teachers']['lastname'], $data['teachers']['firstname'], $data['teachers']['patronymic']]), ['teacher/view', 'id' => $data['teachers']['id']], ['target' => '_blank']);
            }
        ],                 
        [
            'class'     => DataColumn::className(),
            'attribute' => 'status',
            'label'     =>'Статус',
            'value' => function ($data) {
                
                $status = [
                    0 => 'На согласовании',
                    1 => 'Согласовано',
                    2 => 'Отклонено'
                ];

                return $status[$data['status']];
            }
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' =>
                [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['site/view', 'id' => $model['id']]), [
                                'title' => Yii::t('yii', 'View'),
                            ]); }, 
                ]
        ],
        ]
    ]);
?>


    <p>
        Студенты
    </p>


<?=GridView::widget([
    'dataProvider' => $dataProviderStudent,
    'columns' => [
        [
            'class'     => DataColumn::className(),
            'attribute' => 'photo',
            'label'     =>'Фото',
            'format' => 'raw',
            'value' => function ($data){
                return $data['photo'] ? Html::img(Photo::getImage($data['photo']), ['width' => '60px']) : "Не выбрано";
            }
        ],

        [
            'class'     => DataColumn::className(),
            'attribute' => 'lastname',
            'label'     =>'Фамилия'
        ],

        [
            'class'     => DataColumn::className(),
            'attribute' => 'firstname',
            'label'     =>'Имя'
        ],

        [
            'class'     => DataColumn::className(),
            'attribute' => 'patronymic',
            'label'     =>'Отчество'
        ],        

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' =>
                [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['student/view', 'id' => $model['id']]), [
                                'title' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                            ]); }, 

                    'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['student/process', 'id' => $model['id']]), [
                                        'title' => Yii::t('yii', 'Update'),
                                        'data-pjax' => '0',
                                    ]); },                         

                    'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['student/delete','id' => $model['id']]), [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                    ]);
                        }
                ]
        ],
        ]
    ]);
?>

</div>