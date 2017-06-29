<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin([
        'action' => ['post/detail','id' => $id, '#' => 'comments'],
        'method' => 'post',
    ]); ?>

    <div class="row">
    <div class="col-md-12"><?= $form->field($commentComments,'content')->textarea(['rows' => 4]) ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($commentComments->isNewRecord ? '发布' : '修改', ['class' => $commentComments->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>