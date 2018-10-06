<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Admin extends Controller
{
    /*登录*/
    public function login() {
    	if (request()->isPost()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];
            $result = model('Admin')->login($data);
            if ($result == 1) {
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    }

    /*注册*/
    public function register(){
        if(request()->isPost()) {
            $data = [
                'phone' => input('post.phone'),
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];

        $result = model('Admin') -> register($data);
        if ($result == 1) {
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    }
    
    /*注销*/ 
    public function del() {
        if(request()->isPost()){
            $adminInfo = model('Admin')->find(input('post.id'));
            $result = $adminInfo->delete();
        if ($result) {
            return json(['msg' => 'success', 'code' => '200' ]);
        }else {
            return json(['msg' => 'error', 'code' => '304']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    }

    /*编辑*/
    public function edit() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id'),
                'nickname' => input('post.nickname'),
                'phone' => input('post.phone'),
                'address' => input('post.address'),
                'birthday' => input('post.birthday')
            ];
            
            $result = model('Admin') -> edit($data);
            if($result ==1 ){
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    } 
    /*重置密码*/

    public function reset() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id'),
                'oldpass' => input('post.oldpass'),
                'newpass' => input('post.newpass'),
                'conpass' => input('post.conpass')
            ];
            $result = model('Admin') -> reset($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    } 

    /*管理员列表*/
    public function all() {
        if(request()->isGet()) {
            $admins = null;
            $page = input('get.page');
            if($page){
                $admins = model('Admin')->order(['root' => 'asc'])->paginate(10,false,['query' => $page]);
                return json($admins);
            }else {
                $admins = model('Admin')->order(['root' => 'asc'])->paginate(10);
                return json($admins);
            }
        }
    }

    /*管理员查询*/
    public function query() {
        if(request()->isPost()) {
            $data = [
                'username' => input('post.username'),
                'nickname' =>input('post.nickname'),
                'phone' => input('post.phone')
            ];
            if($data['username']) {
                $admin = model('Admin')->where('username', $data['username']) -> find();
                return json(['data'=>$admin , 'code' => 200]);
            } else if($data['nickname']) {
                $admin = model('Admin')->where('nickname', $data['nickname']) -> find();  
                return json(['data'=>$admin , 'code' => 200]); 
            } else if($data['phone']) {
                $admin = model('Admin')->where('phone', $data['phone']) -> find();   
                return json(['data'=>$admin , 'code' => 200]);
            }
        }else {
            return json(['data'=>[] , 'code' => 404]);
        }
        
    }
    /*禁止管理员*/
    public function bar() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id')
            ];
            $result = model('Admin')->bar($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => 'fail', 'code' => 404]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 304]);
        }
        
    }
    /*改变管理员的权限*/
    public function root() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id'),
                'root' =>input('post.root')
            ];
            $result = model('Admin')->root($data);
            if($result == 1 ) {
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => 'fail', 'code' => 404]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 304]);
        }
        
    }
}