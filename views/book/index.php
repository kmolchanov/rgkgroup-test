<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\timeago\TimeAgo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'image',
            'author.fullname',
            [
                'attribute' => 'released_at',
                'value' => function ($model, $index, $widget) {
                    return Yii::$app->formatter->asDatetime($model->released_at, 'd MMMM yyyy');
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model, $index, $widget) {
                    return TimeAgo::widget(['timestamp' => $model->created_at]);
                },
                'format' => 'raw',
            ],
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
