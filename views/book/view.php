<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\timeago\TimeAgo;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute'=>'image',
                'value'=>$model->imageUrl,
                'format' => ['image', ['style' => 'max-width: 100px']],
            ],
            [
                'attribute' => 'released_at',
                'value' => Yii::$app->formatter->asDatetime($model->released_at, 'd MMMM yyyy'),
            ],
            'author.fullname',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
