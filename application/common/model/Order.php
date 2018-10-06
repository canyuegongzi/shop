<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Order extends Model
{
    //软删除
    use SoftDelete;
    //属性的添加
    public function type(){
    	return $this->belongsTo('Type', 'type_id', 'id')->field('type_name,id');
    }
    //关联商品的属性
    public function goodsattr(){
        return $this->hasMany('Goodsattr', 'attr_id', 'id');
    }
    //关联会员
    public function member(){
        return $this->belongsTo('Member', 'member_id', 'id')->field('id,username');
    }
    //关联
    public function orderinfo(){
        return $this->belongsTo('Ordergoods', 'id', 'order_id', 'ordergood');
    }
    public function good(){
        return $this->belongsTo('Good', 'goods_id', 'id')->field('id,goods_name,market_price,sm_logo');
    }
    //添加商品的订单
    public function add($data){

    	$validate = new \app\common\validate\Order();
    	if(!$validate -> scene('add')->check($data)){
    		return $validate -> getError();
    	};
        //获取插入order的id
    	$insertId = $this->insertGetId([
                'member_id' => $data['member_id'],
                'total_price' => $data['total_price'],
                'shr_name' => $data['shr_name'],
                'shr_tel' => $data['shr_tel'],
                'shr_province' => $data['shr_province'],
                'shr_city' => $data['shr_city'],
                'shr_area' => $data['shr_area'],
                'shr_address' => $data['shr_address']
            ]);
        //插入商品订单Ordergoods
    	if($insertId) {
            $result = model('Ordergoods')->insert([
                'order_id' => $insertId,
                'goods_id' => $data['goods_id'],
                'goods_attr_id' => $data['goods_attr_id'],
                'goods_number' => $data['goods_number'],
                'price' => $data['total_price']
                ]);
            if($result){
                return 1;
            }
                return '添加失败';
    		
    	}else {
    		return '添加失败';
    	}
    } 
    //删除商品的订单
    public function del($data){
        if($data['id']){            
            $orderInfo = model('Order')->where('id', $data['id'])->find();
            
            $result = $orderInfo->delete();
            if($result){
                $ordergoodInfo = model('Ordergoods')->where('order_id', $data['id'])->find();
                $result = $ordergoodInfo->delete();
                return 1;
            }else {
                return '删除失败';
            }
        }else {
            return '删除失败';
        }
    }  
    /*
        *处理订单的处理，包括确认发货，确认收货。
        *发货状态,0:未发货,1:已发货2:已收到货 
    */
    public function deal($data){

        $validate = new \app\common\validate\Order();
        if(!$validate -> scene('deal')->check($data)){
            return $validate -> getError();
        };
        if($data['order']) {
            $orderInfo = model('Order')->find($data['id']);
            $orderInfo->post_status = $data['order'];
            $result = $orderInfo -> save();
            if($result) {
                return 1;
            }
            return '订单处理失败';
        }
        return '订单处理失败';
    }
    /*
        *付款
    */
    public function payolder($data){
        
    }
}