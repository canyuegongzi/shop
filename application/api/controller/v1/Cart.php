<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Cart extends Controller
{
	//添加购物车商品
	public function add(){
		if(request()->isPost()){
			$data = [
				'goods_id' => input('post.goodId'),
				'goods_attr_id' => input('post.attrId'),
				'goods_number' => input('post.goodNumber'),
				'member_id' => input('post.memberId')

			];
			$result = model('Cart')->add($data);
			if($result == 1){
				return json(['msg'=>'success','code'=>200,'data'=>$result]);
			}
			return json(['msg'=>'fail','code'=>304,'data'=>$result]);
		}
	}
	/*属性编辑*/
	/*public function edit() {
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
	}*/
	/*购物车删除商品*/
	public function del() {

		if(request()->isPost()){
			$data = [
				'id' => input('post.id')
			];
			$result = model('Cart')->del($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200','data'=>$result]);
        	}else {
            	return json(['msg' => $result, 'code' => '404','data'=>$result]);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304','data'=> 0]);
		}
	}
	/*购物车列表*/
	public function all(){
		$page = 1;
		$result = [];
		$attr = [];
		if(request()) {
            input('page')? $page = input('page') : $page = 1;
            input('good')? $good = input('good') : $good = null;
            input('member')? $member = input('member') : $member = null;
            if($good) {
            	$result = model('Cart')->field('id,goods_id,goods_attr_id,goods_number,member_id,create_time')->with('good,member')->where('goods_id',$good)->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
            }else if ($member) {
            	$result = model('Cart')->field('id,goods_id,goods_attr_id,goods_number,member_id,create_time')->with('good,member')->where('member_id', $member)->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
            }else {
            	$result = model('Cart')->field('id,goods_id,goods_attr_id,goods_number,member_id,create_time')->with('good,member')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
            }
            foreach ($result as $key => $value) {
            	$s = explode(",", $value['goods_attr_id']);           	
            	foreach ($s as $k => $v) {
            		$a = model('Goodsattr')->where('id' , $v)->field('id,attr_value,attr_id')->with('attr')->find();
            		array_push($attr,$a);
            	}         	
            }
            if($result) {
            	return json(['msg' => 'success', 'code' => 200, 'data' => ['data'=>$result,'attr' => $attr]]);
            }
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]);        
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);  
	}
}