<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\timeago\TimeAgo;
use yii\helpers\Url;
use newerton\fancybox\FancyBox;
use smallbearsoft\ajax\Ajax;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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

    <?php
        $this->registerJsFile('/js/books.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
    <?php Pjax::begin([
        'enablePushState' => false,
        'linkSelector' => '#previews a',
    ]);?>

    <?php if (!empty($bookModel)): ?>
        <?php
            Modal::begin([
                'id' => 'book-preview',
                'header' => "<h2>{$bookModel->title}</h2>",
            ]);
        ?>
        <?php
            echo DetailView::widget([
                'model' => $bookModel,
                'attributes' => [
                    'id',
                    'title',
                    [
                        'attribute'=>'image',
                        'value'=>$bookModel->imageUrl,
                        'format' => ['image', ['style' => 'max-width: 100px']],
                    ],
                    [
                        'attribute' => 'released_at',
                        'value' => Yii::$app->formatter->asDatetime($bookModel->released_at, 'd MMMM yyyy'),
                    ],
                    'author.fullname',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]);
        ?>
        <script type="text/javascript">
            showBookPreview();
        </script>
        <?php Modal::end(); ?>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(Html::img($data->imageUrl, ['width'=>'150px']), $data->imageUrl, ['class' => 'fancyboxWindow']);
                },
                'enableSorting' => false,
            ],
            [
                'attribute' => 'author',
                'value' => 'author.fullname',
            ],
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::tag('span', Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                ['index', 'id' => $model->id]), ['id' => 'previews']);
                    },
                    'update' => function ($url, $model) {
                        return Html::tag('span', Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                ['update', 'id' => $model->id], ['target' => '_blank']));
                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end();?>
</div>
