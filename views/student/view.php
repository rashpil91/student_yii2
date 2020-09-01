<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Photo;

$this->title = implode(" ", [$model['lastname'], $model['firstname'], $model['patronymic']]);
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="user-view">

    <h1>Просмотр профиля</h1>

    <?php if ($model['id'] == Yii::$app->user->id OR 1 == 1): ?>
        <p>
            <?= Html::a('Редактировать', ['process', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
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

</div>
