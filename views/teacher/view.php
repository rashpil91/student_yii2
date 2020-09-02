<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Photo;

$this->title = implode(" ", [$model['lastname'], $model['firstname'], $model['patronymic']]);
$this->params['breadcrumbs'][] = ['label' => "Преподаватели", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="user-view">

    <h1>Профиль преподавателя</h1>

    <?php if ($model['id'] == Yii::$app->user->id OR 1 == 1): ?>
        <p>
            <?= Html::a('Редактировать', ['edit', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
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

</div>
