<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Author;
use yii\helpers\ArrayHelper;
use vakorovin\datetimepicker\Datetimepicker;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model, 'released_at')->widget(DateTimePicker::classname(), [
    'options' => [
        'inline' => true,
        'format' => 'unixtime',
        'timepicker' => false,
    ]]); ?>

    <?php
        $authors = Author::find()->orderBy('firstname, lastname')->all();

        $authorsList = ArrayHelper::map($authors,
            'id',
            function($model, $defaultValue) {
                return $model->firstname.' '.$model->lastname;
        });

        echo $form->field($model, 'author_id')->dropDownList($authorsList, [
            'prompt' => 'Select author of the book...',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
