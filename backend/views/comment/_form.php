<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CommentStatus;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <!--<?= $form->field($model, 'status')->textInput() ?>-->

    <?= $form->field($model, 'status')->dropDownList(CommentStatus::find()
        ->select(['name','id'])
        ->orderBy('position')
        ->indexBy('id')
        ->column(),['prompt' => '请选择状态']); ?>

    <!--<?= $form->field($model, 'create_time')->textInput() ?>-->

    <!--<?= $form->field($model, 'userid')->textInput() ?>-->

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <!--<?= $form->field($model, 'post_id')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
