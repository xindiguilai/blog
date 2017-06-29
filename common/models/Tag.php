<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    
    //将字符串转换为数组
    public static function string2array($tags)
    {
        return explode(',', $tags);
    } 

    //将数组转换为字符串
    public static function array2string($tags)
    {
        return implode(',', $tags);
    }

    //处理需要添加的标签
    public static function addTags($tags)
    {
        if(empty($tags)) return;

        foreach ($tags as $name) {
            $aTag = Tag::find()->where(['name' => $name])->one();
            $aTagCount = Tag::find()->where(['name' => $name])->count();

            if(!$aTagCount)
            {
                $tag = new Tag();
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            }
            else
            {
                $aTag->frequency += 1;
                $aTag->save();
            }
        }
    }

    //处理需要删除的标签
    public static function removeTags($tags)
    {
        if(empty($tags)) return;

        foreach ($tags as $name) {
            $aTag = Tag::find()->where(['name' => $name])->one();
            $aTagCount = Tag::find()->where(['name' => $name])->count();

            if($aTagCount)
            {
                if($aTag->frequency <= 1)
                {
                    $aTag->delete();
                }
                else
                {
                    $aTag->frequency -= 1;
                    $aTag->save();
                }
            }
        }
    }

    //更新标签的次数
    public static function updateFrequency($oldTags,$newTags)
    {
        if(!empty($oldTags) || !empty($newTags))
        {
            $oldTagsArray = self::string2array($oldTags);
            $newTagsArray = self::string2array($newTags);

            //var_dump($oldTagsArray);
            //var_dump($newTagsArray);
            //die;

            self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
            self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
        }
    }

    public static function findTagWeights($limit=20)
    {
        $tag_size_level = 5;

        $models = Tag::find()->orderBy('frequency desc')->limit($limit)->all();
        $total = Tag::find()->limit($limit)->count();

        $stepper = ceil($total/$tag_size_level);

        $tags = array();
        $counter = 1;

        if($total > 0)
        {
            foreach ($models as $model) {
                $weight = ceil($counter/$stepper)+1;
                $tags[$model->name] = $weight;
                $counter++;
            }
            ksort($tags);
        }
        return $tags;
    }

}
