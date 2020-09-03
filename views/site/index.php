<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

$this->title = "Курсы для групп";

$dataProvider = new ActiveDataProvider([
    'query' => $model,
    'pagination' => [
        'pageSize' => 50,
    ],
]);

?>

<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <div class="btn-group">
        <?= Html::a('Записать', ['process'], ['class' => 'btn btn-primary']) ?>
        <?= ButtonDropdown::widget([
            'label' => 'Справочники',
            'dropdown' => [
                'items' => [
                    ['label' => 'Студенты', 'url' => '/student/'],
                    ['label' => 'Группы', 'url' => '/student-groupe/'],
                    ['label' => 'Преподаватели', 'url' => '/teacher/'],
                    ['label' => 'Курсы', 'url' => '/course/'],
                ],
            ],
        ]);
        ?>
        </div>
    </p>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class'     => DataColumn::className(),
            'attribute' => 'studentGroupe.number',
            'label'     =>'Группа'
        ],        
        [
            'class'     => DataColumn::className(),
            'attribute' => 'courses.name',
            'label'     =>'Название курса'
        ],
        [
            'class'     => DataColumn::className(),
            'attribute' => 'courses.time',
            'filter' => true,
            'label'     =>'Продолжительность'
        ],
        [
            'class'     => DataColumn::className(),
            'label'     =>'Преподаватель',
            'attribute' => 'teachers',
            'value' => function ($data){
                return implode(" ", [$data['teachers']['lastname'], $data['teachers']['firstname'], $data['teachers']['patronymic']]);
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
            'template' => '{view} {update} {delete}',
            'buttons' =>
                [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['view', 'id' => $model['id']]), [
                                'title' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                            ]); }, 

                    'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['process', 'id' => $model['id']]), [
                                        'title' => Yii::t('yii', 'Update'),
                                        'data-pjax' => '0',
                                    ]); },                         

                    'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete','id' => $model['id']]), [
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