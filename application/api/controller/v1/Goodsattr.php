<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Goodsattr extends Controller
{
	//添加商品的属性
	public function add(){


		if(request()->isPost()){
			$data = [
				'attr_id' => input('post.attrName'),
				'attr_value' => input('post.attrValue'),
				'goods_id' => input('post.goodId')
			];
			
			$result = model('Goodsattr')->add($data);
			if($result==1){
				return json(['msg' => 'success','code' => 200, 'data' => $result]);
			}
			return json(['msg' => 'fail','code' => 404, 'data' => $result]);
		}
		return json(['msg' => 'fail','code' => 304, 'data' => 0]);
	}
	/*属性编辑*/
	public function edit() {
		if(request()->isPost()) {
			$data = [
				'id' => input('post.id'),
				'attr_id' => input('post.attrName'),
				'attr_value' => input('post.attrValue'),
				'goods_id' => input('post.goodId')
			];

			$result = model('Goodsattr')->edit($data);
			if($result == 1) {
				return json(['msg' => 'success', 'code' => '200','data'=>$result]);
			}else {
				return json(['msg' => $result, 'code' => '404','data'=>$result]);
			}
		}else {
			return json(['msg' => 'error', 'code' => '304','data'=>$result]);
		}		
	}
	/*属性删除*/
	public function del() {
		if(request()->isPost()){
			$data = [
				'id' => input('post.id')
			];
			$result = model('Goodsattr')->del($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
	}
	/*获取特定商品得到属性的属性的列表*/ 
	public function info(){

		input('page')? $page = input('page') : $page = 1;
		input('id')? $id = input('id') : $id = null;
		if($id) {
			$attrInfo = model('Goodsattr')->field('id,attr_value,attr_id,goods_id')->with('attr')->where('goods_id', $id)->paginate(10,false,['query' => $page]);
			return json(['msg' =>'success', 'code' => 200, 'data' => $attrInfo]);
		}
		return json(['msg' =>'fail', 'code' => 404, 'data' => 0]);
	}
	
}