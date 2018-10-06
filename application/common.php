<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//vendor ('qiniu.autoload'); 
use phpmailer\phpmailer\PHPMailer;
use phpmailer\phpmailer\Exception;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use think\Image; 
use think\Request;
function mailto($to, $title, $content)
{
    $mail = new PHPMailer(false);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'leruge@163.com';                 // SMTP username
        $mail->Password = 'Ai157511';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('leruge@163.com', '梦中程序员');
        $mail->addAddress($to);     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;

        return $mail->send();
    } catch (Exception $e) {
        exception($mail->ErrorInfo, 1001);
    }
    //把span字符串替换成a

}
function replace($data)
{
    return str_replace('span', 'a', $data);
}

//把字符串转换为数组
function strToArray($data)
{
    return explode('|', $data);
}
//替换
function replaceArray($arr,$detail){
    $newarr = [];
    foreach ($arr as $k => $v) {
        //路径的字符串
        $strs = explode(",", $arr[$k]);
        
        foreach ($strs as $key => $value) {

            foreach ($detail as $index => $item) {
                if($index == $value){
                    $strs[$key] = $item;    
                }
            }
        }
        //替换完成的数组
        $newstr = implode(',',$strs);
        array_push($newarr,$newstr);
    }
    return $newarr;
}
//将将原数据中的path字符串转换为数组
function explodeArray($types){
    $arr = [];
    foreach ($types as $key => $value) {
        $path = explode(",", $value['path']);
        array_push($arr,$value['path']);
    }
    return $arr;
}
//
function upload(){
    $file = request()->file('image');
    // 要上传图片的本地路径
    $filePath = $file->getRealPath();
    $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀
    //获取当前控制器名称
    //$controllerName = 'index';
    // 上传到七牛后保存的文件名
    $key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
    // 需要填写你的 Access Key 和 Secret Key
    $accessKey = config('ACCESSKEY');
    $secretKey = config('SECRETKEY');
    // 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);
    // 要上传的空间
    $bucket = config('BUCKET');
    $domain = config('DOMAINImage');
    $token = $auth->uploadToken($bucket);
    // 初始化 UploadManager 对象并进行文件的上传
    $uploadMgr = new UploadManager();
    // 调用 UploadManager 的 putFile 方法进行文件的上传
    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
    if ($err !== null) {
        echo ["err"=>1,"msg"=>$err,"data"=>""];
    } else {
    //返回图片的完整URL
    var_dump($ret);
    }

}
/*
     * $name为表单上传的name值
     * $filePath为为保存在入口文件夹public下面uploads/下面的文件夹名称，没有的话会自动创建
     * $width指定缩略宽度
     * $height指定缩略高度
     * 自动生成的缩略图保存在$filePath文件夹下面的thumb文件夹里，自动创建
     * @return array 一个是图片路径，一个是缩略图路径，如下：
     * array(2) {
          ["img"] => string(57) "uploads/img/20171211\3d4ca4098a8fb0f90e5f53fd7cd71535.jpg"
          ["thumb_img"] => string(63) "uploads/img/thumb/20171211/3d4ca4098a8fb0f90e5f53fd7cd71535.jpg"
        }
     */
function uploadFile($name,$filePath){
    $file = request()->file($name);
        if($file){
            $filePaths = 'static/uploads' . '/' .$filePath;
            if(!file_exists($filePaths)){
                mkdir($filePaths,0777,true);
            }
            $info = $file->move($filePaths);
            if($info){
                $saveName = str_replace('\\','/',$info->getSaveName());
                $imgpath = 'static/uploads/'.$filePath.'/'.$saveName;
                return [
                    'logo' => $imgpath,
                    'sm_logo' => logoSize($imgpath,100,100,'sm','goods',$saveName),
                    'mid_logo' => logoSize($imgpath,360,360,'mid','goods',$saveName),
                    'big_logo' => logoSize($imgpath,600,600,'big','goods',$saveName),
                    'mbig_logo' => logoSize($imgpath,800,800,'big','goods',$saveName)

                ];
            }else{
                // 上传失败获取错误信息
                return $file->getError();
            }
        }

}

/*生成不同的缩略图*/
function logoSize($file,$width,$height,$size,$types,$saveName){
    //目标路径  
    $targetPath = 'static/uploads/'.$types.'/thumb/'.$size; 
    if(!file_exists($targetPath)){
        mkdir($targetPath,0777,true);
    }
    //文件路径
    $logoName = $targetPath.'/'.str_replace('/','0',$saveName);
    $image = Image::open($file);  
    $image->thumb($width,  $height,  Image::THUMB_CENTER)->save($logoName);
    return $logoName;
}