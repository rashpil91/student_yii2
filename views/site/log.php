<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;

$this->title = 'Журнал действий';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php

$dataProvider = new ActiveDataProvider([
    'query' => $log,
    'pagination' => [
        'pageSize' => 50,
    ],
    'sort' => [
        'defaultOrder' => [
            'date' => SORT_DESC
        ]
    ]
]);

?>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        [
            'class'     => DataColumn::className(),
            'attribute' => 'date',
            'format' => ['date','php:d M y H:i:s'],
            'label'     =>'Время'
        ],

        [
            'class'     => DataColumn::className(),
            'attribute' => 'event',
            'label'     =>'Событие',
            'value' => function ($data) {
                
                $status = [
                    1 => 'Добавление студента',
                    2 => 'Удаление студента'
                ];

                return $status[$data['event']];
            }
        ],
        [
            'class'     => DataColumn::className(),
            'attribute' => 'extra',
            'label'     =>'Детали'
        ],
    ]
    ]);
?>

</div>