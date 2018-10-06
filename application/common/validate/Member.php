<?php
namespace app\common\validate;

use think\Validate;

class Member extends Validate
{
	/*验证规则*/
	protected $rule = [
        'username|管理员账户' => 'require',
        'phone|手机号' => 'require',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'oldpass|原密码' => 'require',
        'newpass|新密码' => 'require',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:admin',
        'code|验证码' => 'require',
        'address|用户收货地址' => 'require',
        'id|用户id' => 'require'
    ];
    /*登录的场景验证*/
    public function sceneLogin() {
    	return $this -> only(['username', 'password']);
    }
    /*注册的场景验证*/
    public function sceneRegister(){
    	return $this -> only(['username','conpass', 'phone','password', 'email'])->append('username', 'unique:admin');
    }
    /*编辑*/
    public function sceneEdit() {
        return $this -> only(['phone','email','id']);
    }
    /*重置密码*/
    public function sceneReset() {
        return $this -> only(['newpass','oldpass']) -> append('conpass', 'confirm:newpass');
    }
}