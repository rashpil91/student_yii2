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
use app\models\Photo;

$this->title = 'Группа № ' . $student_groupe['number'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Студенты
    </p>
    <?php

$dataProvider = new ActiveDataProvider([
    'query' => $student,
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
            'attribute' => 'photo',
            'label'     =>'Фото',
            'format' => 'raw',
            'value' => function ($data){
                return $data->photo ? Html::img(Photo::getImage($data->photo), ['width' => '60px']) : "Не выбрано";
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