<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
//订单管理
class Order extends Controller
{
	/*
		*添加固有的属性和属性值
	*/
	public function add(){
		if(request()->isPost()){
			$data = [
				'goods_id' => input('post.goodId'),
				'goods_attr_id' => input('post.attrId'),
				'goods_number' => input('post.goodNumber'),
				'member_id' => input('post.memberId'),
				'total_price' => input('post.price'),
				'shr_name' => input('post.shrName'),
				'shr_tel' => input('post.shrTel'),
				'shr_province' => input('post.shrProvince'),
				'shr_city' => input('post.shrCity'),
				'shr_area' => input('post.shrArea'),
				'shr_address' => input('post.shrAddress')
			];
			$result = model('Order')->add($data);
			if($result == 1){
				return json(['msg'=>'success','code'=>200,'data'=>$result]);
			}
			return json(['msg'=>'fail','code'=>304,'data'=>$result]);
		}
	}
	/*
		*删除商品的订单
	*/
	public function del(){
		if(request()){
			$data = [
				'id' => input('id')
			];
			$result = model('Order')->del($data);
			if($result == 1 ){
				return json(['msg' => 'success','code' => 200,'data' => $result]);
			}
			return json(['msg' => 'fail','code' => 304,'data' => $result]);
		}
	}
	/*
		*根据相关的post的状态来获取相关的订单
	*/
	public function post(){
		/*post_status*/
		$data = [
			'post' => input('postStatu')
		];
		if(request()){

			$result = model('Order')->where('post_status', $data['post'])->with('member,orderinfo,orderinfo.good')->select();
			return json(['msg'=> 'success', 'code' => 200, 'data'=> $result]);
		}
		return json(['msg'=> 'fail', 'code' => 404, 'data'=> 0]);
	}
	/*
		*根据支付状态来获取相关的订单
	*/	
	public function pay(){
		$data = [
			'pay' => input('pay')
		];
		if(request()){
			input('pay') == 'true' ? $pay = '是' : $pay = '否';
			$result = model('Order')->where('pay_status', $pay)->with('member,orderinfo,orderinfo.good')->select();
			return json(['msg'=> 'success', 'code' => 200, 'data'=> $result]);
		}
		return json(['msg'=> 'fail', 'code' => 404, 'data'=> 0]);
	}
	/*
		*处理订单的处理，包括确认发货，确认收货。
		*发货状态,0:未发货,1:已发货2:已收到货 
	*/
	public function deal(){
		if(request()){
			$data = [
				'order' => input('postStatus'),
				'id' => input('id')
			];
		}else {
			return json(['msg'=> 'fail', 'code' => 304, 'data'=> 0]);
		}
		$result = model('Order')->deal($data);
		if($result == 1) {
			return json(['msg'=> 'success', 'code' => 200, 'data'=> $result]);
		}else {
			return json(['msg'=> 'fail', 'code' => 404, 'data'=> $result]);
		}
	}
	/*
		*付款
	*/
	public function payolder(){
		
	}
}