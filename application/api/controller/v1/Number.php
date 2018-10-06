<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Number extends Controller
{
	//添加库存
	public function add(){
		if(request()->isPost()){
			$data = [
				'goods_id' => input('post.goodId'),
				'goods_number' => input('post.number'),
				'goods_attr_id' => input('post.attrString')
			];

			$result = model('Number')->add($data);
			if($result ==1 ){
				return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);
	}
	//修改库存
	public function edit(){
		if(request()->isPost()){
			$data = [
				'goods_id' => input('post.goodId'),
				'goods_number' => input('post.number'),
				'goods_attr_id' => input('post.attrString')
			];
			$result = model('Number')->edit($data);
			if($result ==1 ){
				return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);

	}
	//获取库存
	public function info(){

		input('id') ? $id = input('id'): $id = null;
		input('attr')? $attr = input('attr'): $attr = input('attr');
		
		if($id && $attr) {
			
			$result = model('Number')->where(['goods_id' => $id, 'goods_attr_id' => $attr])->value('goods_number');
			if($result){
				return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
		}

		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);
		
	}
}