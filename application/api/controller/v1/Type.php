<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Type extends Controller
{
	//商品分类的添加
    public function add() {
    	
    	if(request()->isPost()) {
    		$data = [
    			'type_name' => input('post.name'),
    			'pid' => input('post.pid'),
    			'level' => input('post.level')
    		];
    		$result = model('Type')->add($data);
    		if($result == 1) {
    			return json(['msg' => 'success', 'code' => 200]);
    		}else {
    			return json(['msg' => $result, 'code' => 404]);
    		}
    	}else {
    		return json(['msg' => 'fail', 'code' => 304]);
    	}
    }
    //商品分类的列表
    public function all() {
    	if(request()->isGet()){
    		$result = model('Type')->all();
    		if($result){
    			return json(['msg' => 'success', 'code' => 200 , 'data' => $result]);
    		}else {
    			return json(['msg' => 'fail', 'code' => 404 , 'data' => null]);
    		}
    	}else{
    		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);
    	}

    }
    //商品分类的额编辑
    public function edit() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id'),
                'type_name' => input('post.name'),
                'pid' => input('post.pid'),
                'level' => input('post.level')
            ];
            $result = model('Type')->edit($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => $result, 'code' => 404]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 304]);
        }
    }
    //商品分类的删除
    public function del(){
        if(request()->isPost()){
            $data = [
                'id' => input('post.id')
            ];
            $result = model('Type')->del($data);
            if($result == 1){
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => $result, 'code' => 404]);
            }
            
        }
    }

}    