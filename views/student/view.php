<?php


use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use app\models\Photo;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = implode(" ", [$model['lastname'], $model['firstname'], $model['patronymic']]);
$this->params['breadcrumbs'][] = ['label' => "Студенты", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ArrayDataProvider([
    'allModels' => $model['sgct'],
]);

?>
<div class="user-view">

    <h1>Просмотр профиля</h1>

    <?php if (!Yii::$app->user->isGuest): ?>
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
                'attribute' => 'photo',
                'label' => 'Фото',
                'format' => 'raw',
                'value' => function($data) {
                    return $data['photo'] ? Html::img(Photo::getImage($data['photo'])) : "Не выбрано";
                }
            ],         
            [
                'attribute' => 'firstname',
                'label' => 'Имя',
            ],
            [
                'attribute' => 'lastname',
                'label' => 'Фамилия',
            ],
            [
                'attribute' => 'patronymic',
                'label' => 'Отчество',
            ],
            [
                'attribute' => 'studentGroupe.number',
                'label' => 'Группа',
            ]
        ],
    ]) ?>


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

</div>
