<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommentStatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--
    <p>
        <?= Html::a('创建评论', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '30px'],
            ],
            //'content:ntext',
            /**
            匿名函数
            $model--->当前对象
            $key ---->当前行的键
            $index---->当前行的索引
            $column---->数据列的对象
            function($model,$key,$index,$column)
            */
            [
                'attribute' => 'content',
                'value' => 'beginning',
                /**
                'value' => function($model){
                    $tmpStr = strip_tags($model->content);
                    $tmpLen = strlen($tmpStr);

                    return mb_substr($tmpStr, 0,20,'utf-8').(($tmpLen > 20) ? '...' : '');
                }
                */
            ],
            //'status',
            [
                'attribute' => 'username',
                'label' => '作者',
                'value' => 'user.username',
            ],
            [
                'attribute' => 'status',
                'value' => 'status0.name',
                'filter' => CommentStatus::find()->select(['name','id'])->orderBy('position')->indexBy('id')->column(),
                'contentOptions' => 
                function($model)
                {
                    return ($model->status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-success'];
                }
            ],
            //'create_time:datetime',
            [
                'attribute' => 'create_time',
                'format' => ['date','php:Y-m-d H:i:s'],
            ],
            'post.title',
            //'userid',
            // 'email:email',
            // 'url:url',
            // 'post_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {approve}',
                'buttons' => 
                    [
                        'approve' => function($url,$model,$key)
                        {
                            $options = [
                                'title' => Yii::t('yii','审核'),
                                'aria-label' => Yii::t('yii','审核'),
                                'data-confirm' => Yii::t('yii','你确定通过这条评论吗？'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                        },
                    ],
            ],

        ],
    ]); ?>
</div>
