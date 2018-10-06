<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    //软删除
    use SoftDelete;
    /*会员登录操作*/
    public function login($data){
    	$validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find(); 
        if ($result) {
            if ($result['status'] != 1) {
                return '此账户被禁用！';
            }
            $sessionData = [
                'id' => $result['id'],
                'username' => $result['username']
            ];
            session('member', $sessionData);
            return 1;
        } else {
            return '会员用户名和密码错误！';
        }
    }

    /*会员注册操作*/
    public function register($data){
    	$validate = new \app\common\validate\Member();
    	if(!$validate -> scene('register') -> check($data)){
    		return $validate -> getError();
    	}
        $facePath = uploadFile('face','members');
        
        $data['face'] = $facePath['sm_logo'];
        
    	$result = $this->allowField(true)->save($data);
    	if($result) {
    		return 1;
    	}else {
    		return '注册失败';
    	}
    }

    /*会员信息编辑*/
    public function edit($data) {

        $validate = new \app\common\validate\Member();
        if(!$validate -> scene('edit') ->check($data)) {
            return $validate -> getError();
        }
        $facePath = uploadFile('face','members');
        
        $data['face'] = $facePath['sm_logo'];

        $memberInfo = $this->find($data['id']);
        $memberInfo->phone = $data['phone'];
        $memberInfo->email = $data['email'];
        $memberInfo->face = $data['face'];

        $result = $memberInfo->save();
        if ($result) {
            return 1;
        }else {
            return '会员信息修改失败！';
        }
    }

    /*重置会员密码*/
    public function reset($data) {
        $validate = new \app\common\validate\Member();
        if(!$validate -> scene('reset') -> check($data)) {
            return $validate -> getError();
        }
        $adminInfo = $this->find($data['id']);
        if($adminInfo['password'] != $data['oldpass']) {
            return '原密码不正确';
        }
        $adminInfo->password = $data['newpass'];
        $result = $adminInfo -> save();
        if($result) {
            return 1;
        }else {
            return '密码修改失败';
        }
    }
    /*禁止会员登录*/
    public function bar($data) {
        $memberInfo = $this->find($data['id']);
        $memberInfo->status = 0;
        $result = $memberInfo -> save();
        if($result) {
            return 1;
        }else {
            return '修改失败';
        }
    }

}