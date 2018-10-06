<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Member extends Controller
{
	/*会员登录*/
    public function login() {
    	if (request()->isPost()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];
            $result = model('Member')->login($data);
            if ($result == 1) {
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    }

    /*会员注册*/
    public function register(){
        if(request()->isPost()) {
            $data = [
                'phone' => input('post.phone'),
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'email' => input('post.email')
            ];

        $result = model('Member') -> register($data);
        if ($result == 1) {
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    }
    
    /*会员账号注销*/ 
    public function del() {
        if(request()->isPost()){
            $memberInfo = model('Member')->find(input('post.id'));
            $result = $memberInfo->delete();
        if ($result) {
            return json(['msg' => 'success', 'code' => '200' ]);
        }else {
            return json(['msg' => 'error', 'code' => '304']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }        
    }

    /*会员信息编辑*/
    public function edit() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id'),
                'phone' => input('post.phone'),
                'email' => input('post.email')
            ];            
            $result = model('Member') -> edit($data);
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
            $result = model('Member') -> reset($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => '200' ]);
            }else {
                return json(['msg' => $result, 'code' => '404']);
            }
        }else {
            return json(['msg' => 'error', 'code' => '304']);
        }
        
    } 

    /*会员列表*/
    public function all() {
        if(request()->isGet()) {
            $admins = null;
            $page = input('get.page');
            if($page){
                $members = model('Member')->order(['update_time' => 'asc'])->field('username,id,face,jifen,email,phone,status')->paginate(10,false,['query' => $page]);
                return json(['msg' => 'success','code' =>200,'data'=>$members]);
            }else {
                $members = model('Member')->field('username,id,face,jifen,email,phone,status')->order(['update_time' => 'asc'])->paginate(10);
                return json(['msg' => 'success','code' =>200,'data'=>$members]);
            }
        }
        return json(['msg' => 'fail','code' =>304,'data'=>null]);
    }

    /*会员查询*/
    public function query() {
        if(request()->isPost()) {
            $data = [
                'username' => input('post.username'),
                'phone' => input('post.phone'),
                'email' => input('post.email'),

            ];
            if($data['username']) {
                $members = model('Member')->where('username', $data['username'])->field('username,id,face,jifen,email,phone,status')->find();
                return json(['msg'=>'sucess', 'code' => 200,'data'=>$members ]);
            } else if($data['phone']) {
                $members = model('Member')->where('phone', $data['phone'])->field('username,id,face,jifen,email,phone,status')->find();  
                return json(['msg'=>'sucess', 'code' => 200,'data'=>$members ]);
            } else if($data['email']) {
                $members = model('Member')->where('email', $data['email'])->field('username,id,face,jifen,email,phone,status')->find();   
                return json(['msg'=>'sucess', 'code' => 200,'data'=>$members ]);
            }
        }else {
            return json(['msg'=>'sucess', 'code' => 200,'data'=>null]);
        }
        
    }
    /*禁止会员*/
    public function bar() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id')
            ];
            $result = model('Member')->bar($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => 'fail', 'code' => 404]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 304]);
        }
        
    }
    /*具体会员详情*/
    public function info() {
        if(request()) {
            $data = [
                'id' => input('post.id')
            ];
            $result = model('Member')->where('id',$data['id'])->field('id,username,face,jifen,create_time,email,status,phone')->find();
            if($result) {
                return json(['msg' => 'success', 'code' => 200,'data'=>$result]);
            }else {
                return json(['msg' => 'fail', 'code' => 404,'data'=>null]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 304,'data'=>null]);
        }
        
    }
}