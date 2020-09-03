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

$this->title = 'Курсы';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php if (!Yii::$app->user->isGuest) echo Html::a('Добавить', ['add'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php

$dataProvider = new ActiveDataProvider([
    'query' => $course,
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
            'attribute' => 'name',
            'label'     =>'Название'
        ],

        [
            'class'     => DataColumn::className(),
            'attribute' => 'time',
            'label'     =>'Продолительность'
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
                                return Yii::$app->user->isGuest ? false : Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['edit', 'id' => $model['id']]), [
                                        'title' => Yii::t('yii', 'Update'),
                                        'data-pjax' => '0',
                                    ]); },                         

                    'delete' => function ($url, $model) {
                                return Yii::$app->user->isGuest ? false : Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete','id' => $model['id']]), [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => "Вы уверены, что хотите удалить этот курс? Вместе с ним будут удалены все связанные записи",
                                    ]);
                        }
                ]
        ],
        ]
    ]);
?>

</div>