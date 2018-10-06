<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
// 订单管理
class Ordergoods extends Controller
{
	/*订单的搜索*/
	public function query(){
		//分页的页数
		input('page')? $page = input('page'): $page = 1;
		//会员的会员
		input('member')? $member = input('member'): $member = null;
		//商品的名称
		input('good')? $good = input('good'): $good = null;
		//存储属性的数组
		$arr = [];
		//根据商品的名称获取相关的订单
		if($good){
			//商品的id
			$id = model('Good')->where('goods_name', 'like', '%' . $good . '%')->value('id');
			//会员的id
			$result = model('Ordergoods')->where('goods_id', $id)->with('order,good,order.member')->paginate(10,false,['query' => $page]);
			//处理先关属性的查找
			foreach ($result as $key => $value) {
				array_push($arr, explode(',',$value['goods_attr_id']));
			}
			return json(['msg'=> 'success', 'code' => 200, 'data'=> $result]);
			//根据会员查找相关的订单
		}else if($member){
			$memberId = model('Member')->where('username', $member)->value('id');
			$result = model('Order')->where('member_id', $memberId)->with('member,orderinfo,orderinfo.good')->select();
			return json(['msg'=> 'success', 'code' => 200, 'data'=> $result]);
			//如果没有商品和会员的条件的话就是获取所有的商品的订单
		}else {
			$result = model('Ordergoods')->with('order,good,order.member')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
			return json(['msg'=> 'success', 'code' => 200, 'data'=> $result]);
		}
	}
}