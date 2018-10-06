<?php
namespace app\common\validate;

use think\Validate;

class Order extends Validate
{
	protected $rule = [
        'goods_id|商品id' => 'require',
        'goods_attr_id|商品属性的特性' => 'require',
        'goods_number|商品数量' => 'require',
        'member_id|会员id' => 'require',
        'total_price|总价' => 'require',
        'shr_name|收货人姓名' => 'require',
        'shr_tel|收货人电话' => 'require',
        'shr_province|收货人省份' => 'require',
        'shr_city|收货人城市' => 'require',
        'shr_area|收货人区域' => 'require',
        'shr_address|收货人地址' => 'require',
        'order|订单处理的状态' => 'require|number|between:0,2'
    ];
    /*添加固有属性验证场景*/
    public function sceneAdd() {
    	return $this->only(['goods_id', 'goods_attr_id', 'goods_number', 'member_id', 'total_price', 'shr_name', 'shr_tel','shr_province','shr_city','shr_area','shr_address']);
    }
    /*编辑固有属性验证场景*/
    public function sceneEdit() {
    	return $this->only(['attr_name', 'attr_type', 'type_id']);
    }
    /*处理订单*/
    public function sceneDeal() {
        return $this->only(['order']);
    }
}
