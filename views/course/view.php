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
                'attribute' => 'name',
                'label' => 'Название',
            ],
            [
                'attribute' => 'time',
                'label' => 'Продолжительность',
            ],
            [
                'attribute' => 'studentGroupe',
                'label' => 'Изучают группы',
                'format' => "raw",
                'value' => function($data) 
                {
                    return Html::ul($data['studentGroupe'], ['item' => function($item, $index) {
                        return  Html::tag(
                            'li', Html::a( "№ " . $item['number'], ['student-groupe/view', 'id' => $item['id']], ['target' => '_blank'])
                        );
                    }]);
                }
            ],
            [
                'attribute' => 'teacher',
                'label' => 'Преподают',
                'format' => "raw",
                'value' => function($data) 
                {
                    return Html::ul($data['teacher'], ['item' => function($item, $index) {
                        return  Html::tag(
                            'li', Html::a(implode(" ", [$item['lastname'], $item['firstname'], $item['patronymic']]), ['teacher/view', 'id' => $item['id']], ['target' => '_blank'])
                        );
                    }]);
                }
            ],                        
        ],
    ]) ?>

</div>
