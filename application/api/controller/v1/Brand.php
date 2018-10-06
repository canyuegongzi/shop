<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Brand extends Controller
{
	/*添加品牌*/
	public function add() {
		if(request()->isPost()) {
			$data = [
    		'brand_name' => input('post.brand'),
    		'desc' => input('post.desc')
    		];
    		$result = model('Brand') -> add($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
		
	}
	/*品牌删除*/
	public function del() {
		if(request()->isPost()){
			$data = [
				'id' => input('post.id')
			];
			$result = model('Brand')->del($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
	}
	/*品牌编辑*/
	public function edit() {
		if(request()->isPost()) {
			$data = [
				'id' => input('post.id'),
				'brand_name' => input('post.brand'),
				'desc' => input('post.desc')
			];
			$result = model('Brand')->edit($data);
			if($result == 1) {
				return json(['msg' => 'success', 'code' => '200']);
			}else {
				return json(['msg' => $result, 'code' => '404']);
			}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
		
	}
	/*品牌列表*/
	public function all(){
		$page = 1;
		if(request()) {
            $cates = null;
            $page = input('get.page');
            input('page')? $page = input('page') : $page = 1;

            $result = model('Brand')->order(['update_time' => 'asc'])->paginate(2,false,['query' => $page]);
            if($result) {
            	return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
            }
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]);        
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);  
		}      
}