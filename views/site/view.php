<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use app\models\Photo;

$this->title = "Детали курса";
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ArrayDataProvider([
    'allModels' => $model['student'],
]);

?>
<div class="user-view">

    <?php if ($model['id'] == Yii::$app->user->id OR 1 == 1): ?>
        <p>
            <div class="btn-group">
                <?= Html::a('Редактировать', ['process', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model['id']], ['class' => 'btn btn-danger', 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) ?>
            </div>
        </p>
    <?php endif; ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [       
            [
                'attribute' => 'courses.name',
                'label'     =>'Название курса',
                'format' => "raw",
                'value' => function($data) 
                {
                    return Html::a($data['courses']['name'], ['course/view', 'id' => $data['courses']['id']], ['target' => '_blank']);
                }
                
            ],
            [
                'attribute' => 'courses.time',
                'label' => 'Продолжительность',
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
            [
                'attribute' => 'studentGroupe',
                'label' => 'Группа',
                'format' => "raw",
                'value' => function($data) 
                {
                    return Html::a( "№ " . $data['studentGroupe']['number'], ['student-groupe/view', 'id' => $data['studentGroupe']['id']], ['target' => '_blank']);
                }
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
        ]
    ]) ?>

    <p>
        <h3>Студенты</h3>
    </p>    

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
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
                                'target' => '_blank',
                            ]); }, 

                    'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['student/process', 'id' => $model['id']]), [
                                        'title' => Yii::t('yii', 'Update'),
                                        'target' => '_blank',
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
