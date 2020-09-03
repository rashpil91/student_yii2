<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;

$this->title = implode(" ", [$model['lastname'], $model['firstname'], $model['patronymic']]);
$this->params['breadcrumbs'][] = ['label' => "Преподаватели", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <h1>Профиль преподавателя</h1>

    <?php if ($model['id'] == Yii::$app->user->id OR 1 == 1): ?>
    <p>
            <div class="btn-group">
                <?= Html::a('Редактировать', ['edit', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model['id']], ['class' => 'btn btn-danger', 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) ?>
            </div>
        </p>
    <?php endif; ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [       
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
            ]
        ],
    ]) ?>

    <h1>Ведет курсы</h1>

    <?php

$dataProvider = new ActiveDataProvider([
    'query' => $student_groupe_course,
    'pagination' => [
        'pageSize' => 10,
    ],
]);

?>

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
            'attribute' => 'status',
            'label'     =>'Статус',
            'value' => function ($data) {
                
                $status = [
                    0 => 'На согласовании',
                    1 => 'Согласовано',
                    2 => 'Отклонено'
                ];

                return $status[$data->status];
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
