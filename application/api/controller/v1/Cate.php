<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Cate extends Controller
{
	/*添加图书栏目*/
	public function add() {
		if(request()->isPost()) {
			$data = [
    		'catename' => input('post.catename'),
    		'sort' => input('post.sort')
    		];
    		$result = model('Cate') -> add($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
		
	}
	/*图书栏目删除*/
	public function del() {
		if(request()->isPost()){
			$data = [
				'id' => input('post.id')
			];
			$result = model('Cate')->del($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
		
	}
	/*图书栏目编辑*/
	public function edit() {
		if(request()->isPost()) {
			$data = [
				'id' => input('post.id'),
				'catename' => input('post.catename'),
				'sort' => input('post.sort')
			];
			$result = model('Cate')->edit($data);
			if($result == 1) {
				return json(['msg' => 'success', 'code' => '200' ]);
			}else {
				return json(['msg' => $result, 'code' => '404']);
			}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
		
	}
	/*图书栏目列表*/
	public function all(){
		if(request()) {
            $cates = null;
            $page = input('get.page');
            if($page){
                $cates = model('Cate')->order(['sort' => 'asc'])->paginate(2,false,['query' => $page]);
                return json(['msg' => 'success', 'code' => 200,'data' => $cates]);
            }else {
                $cates = model('Cate')->order(['sort' => 'asc'])->paginate(2);
                return json(['msg' => 'success', 'code' => 200, 'data' => $cates]);
            }
        }else {
        	return json(['msg' => 'fail', 'code' => 304, 'data' => null]);
        } 
        
	}
}