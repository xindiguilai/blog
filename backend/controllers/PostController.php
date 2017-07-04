<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['index', 'view'],
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'], //普通用户(游客，未登陆的用户)
                    ],
                    [
                        'actions' => ['view', 'index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'], //判断是否是已登陆用户
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->layout = false;
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        //$post = Yii::$app->db->createCommand("select * from post")->queryAll();
        //$post = Yii::$app->db->createCommand("select * from post")->queryOne();
        //$post = Yii::$app->db->createCommand("select * from post where id = :id and status = :status")
        //->bindValue(":id",$_GET['id'])
        //->bindValue(":status",2)
        //->queryOne();

        //$model = Post::find()->where(['id' => 32])->one();
        //$model = Post::find()->where(['status' => 2])->all();
        //$model = Post::findOne(32);
        //$model = Post::findAll(['status' => 2]);
        //$model = Post::find()->where(['and',['status' => 2],['author_id' => 1]])->orderBy('id desc')->all();

        /**
        foreach ($model as $value) {
            echo $value->id.'<br />';
            echo $value->title.'<br />';
        }
        

        //create
        $post = new Post();
        $post->title = 'hello world';
        $post->content = 'hello content';
        $post->save();
        //等同于
        $post->insert();

        //read
        $post = Post::findOne($id);

        //update
        $post = Post::findOne($id);
        $post->title = 'hello email';
        $post->save();
        //等同于
        $post->update();

        //delete
        $post = Post::findOne($id);
        $post->delete();

        var_dump($model);
        
        echo '<pre>';
        print_r($model);
        die;
        */

        //$model = Post::find()->where(['id' => 33])->one();
        //var_dump($model);die;
        //echo $model->status0->name;
        //die;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTest(){
        //Post->getMaxId();
        //$post = Post::find()->orderBy('id desc')->one;
        $post = Yii::$app->db->createCommand("select max(id) as id from post")->queryOne();
        //$post = Yii::$app->db->createCommond("select * from post")->queryAll();
        echo '<pre>';
        print_r($post);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        if(!Yii::$app->user->can('createPost')){
            throw new ForbiddenHttpException("对不起，你没有进行该操作的权限");
        }

        $model = new Post();

        //$model->create_time = time();
        //$model->update_time = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        if(!Yii::$app->user->can('updatePost')){
            throw new ForbiddenHttpException("对不起，你没有进行该操作的权限");
        }

        $model = $this->findModel($id);

        //$model->update_time = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        if(!Yii::$app->user->can('deletePost')){
            throw new ForbiddenHttpException("对不起，你没有进行该操作的权限");
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
