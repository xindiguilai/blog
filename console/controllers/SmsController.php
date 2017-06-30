<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Comment;

class SmsController extends Controller
{

   public function actionSend()
   {

        $newCommentCount = Comment::find()->where(['status' => 1, 'remind' => 0])->count();

        if($newCommentCount > 0)
        {
            $content = "有".$newCommentCount."条新评论待审核！";

            $result = $this->vendorSmsService($content);

            if($result['status'] == "success")
            {
                Comment::updateAll(['remind' => 1]);    //把提醒标志全部设为已提醒
                echo '['.date('Y-m-d H:i:s',$result['dt']).']'.$content.'['.$result['length'].']'."\r\n";
            }
            return 0;   //退出代码
        }

   }

   protected function vendorSmsService($content)
   {
        //实现第三方短信供应商提供的短信发送接口

        /**
        $username = "companyname";    //用户名
        $password = "pwdforwaord";    //密码
        $apikey = "5782abckeor8928239";     //apikey
        $mobile = "13311484509";      //手机号

        $url = "http://sms.vendor.com/api/sned/?";

        $data = array(
              'username' = $username,
              'password' = $password,
              'apikey' = $apikey,
              'mobile' = $mobile,
        );

        $result = $this->curlSend($url,$data);
        */

        $result = array("status" => "success", "dt" => time(), "length" => 43);   //模拟数据
        return $result;
   }

}