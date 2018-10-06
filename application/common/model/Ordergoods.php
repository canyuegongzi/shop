<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Ordergoods extends Model
{
    //软删除
    use SoftDelete;
    //属性的添加
    public function order(){
    	return $this->belongsTo('Order', 'order_id', 'id')->field('id,member_id,total_price,shr_name');
    }
    //关联商品的属性
    public function goodsattr(){
        return $this->hasMany('Goodsattr', 'goods_attr_id', 'id')->field('id,order_id,goods_id,goods_attr_id,goods_number,price,create_time');
    }  
    //关联商品
    public function good(){
        return $this->belongsTo('Good', 'goods_id', 'id')->field('id,goods_name,market_price,sm_logo');
    }

    
}