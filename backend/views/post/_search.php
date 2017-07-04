<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
/**
<!--
    <?= //$form->field($model, 'id') ?>

    <?= //$form->field($model, 'title') ?>

    <?= //$form->field($model, 'authorName') ?>

    <?= //$form->field($model, 'tags') ?>

    <?= //$form->field($model, 'status') ?>
-->
*/
?>

<div class="post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'update_time')->widget(DatePicker::classname(), [ 
    'options' => ['placeholder' => ''], 
    'value' => '', 
    'pluginOptions' => [ 
        'autoclose' => true, 
        'todayHighlight' => true, 
        'format' => 'yyyy-mm-dd', 
    ]]); ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>