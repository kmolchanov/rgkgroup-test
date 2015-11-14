<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="form-group">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-6">
                    <?php
                        $authors = Author::find()->orderBy('firstname, lastname')->all();

                        $authorsList = ArrayHelper::map($authors,
                            'id',
                            function($model, $defaultValue) {
                                return $model->firstname.' '.$model->lastname;
                        });

                        echo $form->field($model, 'author')->dropDownList($authorsList, [
                            'prompt' => 'Select author of the book...',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'title') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-3">
                    <?php
                        echo $form->field($model, 'released_from')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter date ...'],
                            'pluginOptions' => [
                                'autoclose'=>true
                            ]
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?php
                        echo $form->field($model, 'released_to')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter date ...'],
                            'pluginOptions' => [
                                'autoclose'=>true
                            ]
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
