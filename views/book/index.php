<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\timeago\TimeAgo;
use yii\helpers\Url;
use newerton\fancybox\FancyBox;

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

    <?= FancyBox::widget([
        'target' => 'a[class=fancyboxWindow]',
        'config' => [
            'maxWidth' => '90%',
            'maxHeight' => '90%',
            'playSpeed' => 7000,
            'padding' => 0,
            'fitToView' => false,
            'width' => '70%',
            'height' => '70%',
            'autoSize' => false,
            'closeClick' => false,
            'openEffect' => 'elastic',
            'closeEffect' => 'elastic',
            'prevEffect' => 'elastic',
            'nextEffect' => 'elastic',
            'closeBtn' => false,
            'openOpacity' => true,
        ]
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(Html::img($data->imageUrl, ['width'=>'150px']), $data->imageUrl, ['class' => 'fancyboxWindow']);
                },
            ],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
