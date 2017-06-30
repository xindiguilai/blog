<?php

namespace common\models;

use Yii;
use common\models\PostStatus;
use common\models\Adminuser;
use common\models\Tag;
use common\models\Comment;
use yii\helpers\Html;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 */
class Post extends \yii\db\ActiveRecord
{
    
    private $_oldTags;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['content', 'tags'], 'string'],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'author_id' => '作者',
        ];
    }

    //hasOne是多对一，一对一
    //hasMany是一对多的情空
    public function getStatus0(){
        return $this->hasOne(PostStatus::className(),['id' => 'status']);
    }

    public function getAuthor(){
        return $this->hasOne(Adminuser::className(),['id' => 'author_id']);
    }

    /**
    public function getMaxId(){
        $post = Yii::$app->db->createCommand("select max(id) as id from post")->queryOne();
        return $post['id'];
    }
    */

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                //$this->id = $this->getMaxId() + 1;
                $this->create_time = time();
                $this->update_time = time();
            }else{
                $this->update_time = time();
            }
            return true;
        }else{
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        //var_dump($this->_oldTags);
        //var_dump($this->tags);
        //die;
        Tag::updateFrequency($this->_oldTags,$this->tags);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Tag::updateFrequency($this->tags,'');
    }

    public function getUrl()
    {
        return Yii::$app->urlManager->createUrl(
            //['post/detail','id' => $this->id, 'title' => $this->title]
            ['post/detail','id' => $this->id]
        );
    }

    public function getBeginning($length = 288)
    {
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);

        return mb_substr($tmpStr, 0, $length, 'utf-8').(($tmpLen > $length) ? '...' : '');
    }

    public function getTagLinks()
    {
        $links = array();

        foreach (Tag::string2array($this->tags) as $tag) {
            $links[] = Html::a(Html::encode($tag),array('post/index','PostSearch[tags]' => $tag));
        }
        return $links;
    }

    public function getCommentCount()
    {
        return Comment::find()->where(['post_id' => $this->id, 'status' => 2])->count();
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getActiveComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])->where('status = :status', [':status' => 2])->orderBy('id desc');
    }

    /**

    $rows = new yii\db\Query()
    ->select(['id','email'])
    ->from('user')
    ->where(['last_name' => 'swith'])
    ->orderBy('id')
    ->limit(10)
    ->indexBy('id')
    ->all();

    all()   返回数组
    one()   返回第一行
    column()    返回第一列
    count()
    sum()
    max()
    min()

    */

}
