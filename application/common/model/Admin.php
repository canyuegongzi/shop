<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;
    /*登录操作*/
    public function login($data){
    	$validate = new \app\common\validate\Admin();
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
                'nickname' => $result['nickname'],
                'is_super' => $result['is_super']
            ];
            session('admin', $sessionData);
            return 1;
        } else {
            return '用户名或者密码错误！';
        }
    }

    /*注册操作*/
    public function register($data){
    	$validate = new \app\common\validate\Admin();
    	if(!$validate -> scene('register') -> check($data)){
    		return $validate -> getError();
    	}
    	$result = $this->allowField(true)->save($data);
    	if($result) {
    		return 1;
    	}else {
    		return '注册失败';
    	}
    }

    /*编辑*/
    public function edit($data) {

        $validate = new \app\common\validate\Admin();
        if(!$validate -> scene('edit') ->check($data)) {
            return $validate -> getError();
        }
        $adminInfo = $this->find($data['id']);
        $adminInfo->nickname = $data['nickname'];
        $adminInfo->phone = $data['phone'];
        $adminInfo->address = $data['address'];
        $adminInfo->birthday = $data['birthday'];

        $result = $adminInfo->save();
        if ($result) {
            return 1;
        }else {
            return '管理员修改失败！';
        }
    }

    /*重置密码*/
    public function reset($data) {
        $validate = new \app\common\validate\Admin();
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
    /*管理员列表*/
    public function all() {
        $page = input('page');
        $admins = model('Admin')->order(['is_super' => 'asc', 'status' => 'asc'])->paginate(10);
    }
    /*禁止管理员*/
    public function bar($data) {
        $adminInfo = $this->find($data['id']);
        $adminInfo->status = 0;
        $result = $adminInfo -> save();
        if($result) {
            return 1;
        }else {
            return '修改失败';
        }
    }
    /*修改权限*/
    public function root($data) {
        $adminInfo = $this -> find($data['id']);
        $adminInfo->root = $data['root'];
        $result = $adminInfo -> save();
        if($result) {
            return 1;
        }else {
            return '修改失败';
        }
    }

}