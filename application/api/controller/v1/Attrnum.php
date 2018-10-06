<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Attrnum extends Controller
{
	// 添加固有的属性和属性值
	public function add(){
		if(request()->isPost()){
			$data = [
				'attr_name' => input('post.name'),
				'attr_type' => input('post.attrType'),
				'attr_option_values' => input('post.attrValues'),
				'type_id' => input('post.type')
			];
			$result = model('Attrnum')->add($data);
			if($result == 1){
				return json(['msg'=>'success','code'=>200,'data'=>$result]);
			}
			return json(['msg'=>'fail','code'=>304,'data'=>$result]);
		}
	}
	/*属性编辑*/
	public function edit() {
		if(request()->isPost()) {
			$data = [
				'id' => input('post.id'),
				'attr_name' => input('post.name'),
				'attr_type' => input('post.attrType'),
				'attr_option_values' => input('post.attrValues'),
				'type_id' => input('post.type')
			];
			$result = model('Attrnum')->edit($data);
			if($result == 1) {
				return json(['msg' => 'success', 'code' => '200']);
			}else {
				return json(['msg' => $result, 'code' => '404']);
			}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}		
	}
	/*属性删除*/
	public function del() {
		if(request()->isPost()){
			$data = [
				'id' => input('post.id')
			];
			$result = model('Attrnum')->del($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
	}
	/*属性列表*/
	public function all(){
		$page = 1;
		if(request()) {
            $page = input('get.page');
            input('page')? $page = input('page') : $page = 1;

            $result = model('Attrnum')->field('id,attr_name,attr_type,attr_option_values,type_id')->with('type')->order(['update_time' => 'asc'])->paginate(10,false,['query' => $page]);
            if($result) {
            	return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
            }
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]);        
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);  
	}
	/*属性搜索*/
	public function query(){
		$page = 1;
		$keyword = input('keyword');
		if($keyword){

			$id = model('type')->where('type_name', 'like', '%' . $keyword . '%')->where('level',1)->value('id');
			$attrInfo = model('Attrnum')->where('type_id',$id)->with('Type')->field('id,attr_name,attr_type,attr_option_values,type_id')->select();
			if($attrInfo) {
				return json(['msg'=>'success','code'=>200,'data'=>$attrInfo]);
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]); 
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);  
	}      
}