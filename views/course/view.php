<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model['name'];
$this->params['breadcrumbs'][] = ['label' => "Курсы", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <h1>Курс</h1>

    <?php if ($model['id'] == Yii::$app->user->id OR 1 == 1): ?>
        <p>
            <?= Html::a('Редактировать', ['edit', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [       
            [
                'attribute' => 'name',
                'label' => 'Название',
            ],
            [
                'attribute' => 'time',
                'label' => 'Продолжительность',
            ],
        ],
    ]) ?>

</div>
